<?php

namespace App\Services;

use Anthropic\Client;
use App\Models\Chord;
use App\Models\Note;
use App\Models\Product;
use Illuminate\Support\Facades\Http;
use RuntimeException;

/**
 * Extrae el perfil olfativo de un perfume (acordes, pirámide, longevidad,
 * estela, uso día/noche y estaciones) a partir de una captura de pantalla
 * o de la URL de una ficha tipo Fragrantica, usando la API de Claude, y
 * lo aplica directamente al producto (creando/vinculando Acordes y Notas
 * si hace falta) para no tener que cargarlo todo a mano.
 */
class FragranticaImportService
{
    protected Client $client;

    public function __construct()
    {
        $apiKey = config('services.anthropic.key');

        if (blank($apiKey)) {
            throw new RuntimeException(
                'Falta configurar ANTHROPIC_API_KEY en el archivo .env del servidor para poder usar la importación automática.'
            );
        }

        $this->client = new Client(apiKey: $apiKey);
    }

    /**
     * @param  string  $base64  Contenido de la imagen codificado en base64 (sin el prefijo data:...)
     * @param  string  $mediaType  Ej. 'image/png', 'image/jpeg'
     */
    public function desdeImagen(string $base64, string $mediaType): array
    {
        return $this->extraer([
            [
                'type' => 'image',
                'source' => ['type' => 'base64', 'media_type' => $mediaType, 'data' => $base64],
            ],
            ['type' => 'text', 'text' => $this->prompt()],
        ]);
    }

    public function desdeUrl(string $url): array
    {
        $respuesta = Http::withHeaders([
            'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0 Safari/537.36',
            'Accept-Language' => 'es-ES,es;q=0.9,en;q=0.8',
        ])->timeout(20)->get($url);

        if (! $respuesta->successful()) {
            throw new RuntimeException(
                "No se pudo acceder a esa URL (código {$respuesta->status()}). Fragrantica suele bloquear accesos automatizados; prueba subiendo una captura de pantalla en su lugar."
            );
        }

        $html = $respuesta->body();
        $texto = preg_replace('/<(script|style)\b[^>]*>.*?<\/\1>/is', '', $html);
        $texto = strip_tags($texto);
        $texto = html_entity_decode($texto, ENT_QUOTES, 'UTF-8');
        $texto = trim(preg_replace('/\s+/', ' ', $texto));
        $texto = mb_substr($texto, 0, 15000);

        if ($texto === '') {
            throw new RuntimeException('La página no devolvió contenido legible. Prueba subiendo una captura de pantalla en su lugar.');
        }

        return $this->extraer([
            ['type' => 'text', 'text' => "Contenido de la página (texto plano extraído del HTML):\n\n{$texto}"],
            ['type' => 'text', 'text' => $this->prompt()],
        ]);
    }

    /**
     * Aplica los datos extraídos a un producto ya existente: actualiza los
     * campos de perfil olfativo y crea/vincula los Acordes y Notas que
     * falten, sin borrar nada que el usuario ya hubiera cargado si la IA
     * no encontró ese dato (vuelve null => no se toca ese campo).
     */
    public function aplicarAProducto(Product $product, array $datos): void
    {
        $camposProducto = array_filter([
            'longevidad_horas' => $datos['longevidad_horas'] ?? null,
            'estela' => $datos['estela'] ?? null,
            'uso_dia_pct' => $datos['uso_dia_pct'] ?? null,
            'temporada_invierno_pct' => $datos['temporada_invierno_pct'] ?? null,
            'temporada_primavera_pct' => $datos['temporada_primavera_pct'] ?? null,
            'temporada_verano_pct' => $datos['temporada_verano_pct'] ?? null,
            'temporada_otono_pct' => $datos['temporada_otono_pct'] ?? null,
        ], fn ($valor) => $valor !== null);

        if ($camposProducto !== []) {
            $product->update($camposProducto);
        }

        foreach (($datos['acordes'] ?? []) as $acorde) {
            $nombre = trim($acorde['nombre'] ?? '');
            if ($nombre === '') {
                continue;
            }

            $chord = Chord::firstOrCreate(
                ['name' => $nombre],
                ['color' => $this->colorDesdeNombre($nombre)]
            );

            $intensidad = (int) ($acorde['intensidad'] ?? 50);
            $product->chords()->syncWithoutDetaching([$chord->id => ['intensity' => max(1, min(100, $intensidad))]]);
        }

        $this->vincularNotas($product, $datos['notas_salida'] ?? [], 'top');
        $this->vincularNotas($product, $datos['notas_corazon'] ?? [], 'heart');
        $this->vincularNotas($product, $datos['notas_fondo'] ?? [], 'base');
    }

    protected function vincularNotas(Product $product, array $nombres, string $tipo): void
    {
        foreach ($nombres as $nombre) {
            $nombre = trim((string) $nombre);
            if ($nombre === '') {
                continue;
            }

            $note = Note::firstOrCreate(['name' => $nombre, 'type' => $tipo]);
            $product->notes()->syncWithoutDetaching([$note->id]);
        }
    }

    protected function extraer(array $contenido): array
    {
        $mensaje = $this->client->messages->create(
            model: 'claude-opus-5-5',
            maxTokens: 2000,
            messages: [
                ['role' => 'user', 'content' => $contenido],
            ],
        );

        $texto = null;

        foreach ($mensaje->content as $bloque) {
            if ($bloque->type === 'text') {
                $texto = $bloque->text;
                break;
            }
        }

        if ($texto === null) {
            throw new RuntimeException('La IA no devolvió una respuesta de texto.');
        }

        $texto = trim($texto);
        $texto = preg_replace('/^```(?:json)?\s*|\s*```$/', '', $texto);

        $datos = json_decode($texto, true);

        if (! is_array($datos)) {
            throw new RuntimeException('No se pudo interpretar la respuesta de la IA. Intenta de nuevo, o con una captura más clara / completa.');
        }

        return $datos;
    }

    protected function prompt(): string
    {
        return <<<'TEXTO'
            Eres un asistente que extrae datos de fichas de perfumes (como las de Fragrantica) para cargarlos en un catálogo.
            A partir del contenido que te doy (una imagen de la ficha, o el texto extraído de la página), devuelve ÚNICAMENTE un JSON válido, sin texto adicional ni markdown, con esta forma exacta:

            {
              "acordes": [ { "nombre": "Cítrico", "intensidad": 80 } ],
              "notas_salida": ["Bergamota", "Limón"],
              "notas_corazon": ["Jazmín"],
              "notas_fondo": ["Almizcle", "Vainilla"],
              "longevidad_horas": 8,
              "estela": "Enorme",
              "uso_dia_pct": 60,
              "temporada_invierno_pct": 40,
              "temporada_primavera_pct": 30,
              "temporada_verano_pct": 40,
              "temporada_otono_pct": 15
            }

            Reglas:
            - "acordes": lista de acordes principales (el gráfico de barras de colores) con su intensidad relativa de 0 a 100, respetando el orden/proporción visual. Si no hay un número visible, estima la intensidad según el orden y el tamaño de cada barra (la primera suele ser la más intensa).
            - Traduce nombres de notas y acordes al español si el original está en inglés (ej. "Bergamot" -> "Bergamota", "Woody" -> "Amaderado").
            - "estela" debe ser exactamente una de estas palabras: Suave, Moderada, Fuerte, Enorme (traduce Soft/Light->Suave, Moderate->Moderada, Heavy/Strong->Fuerte, Huge/Enormous->Enorme).
            - "uso_dia_pct": de 0 a 100, donde 100 es "solo de día" y 0 "solo de noche", según el indicador día/noche de la ficha.
            - Los cuatro "temporada_*_pct": de 0 a 100 según qué tan recomendada aparece esa estación en la ficha (si se ve apagada/gris, usa un valor bajo o 0; si está resaltada, un valor alto).
            - Si un dato no aparece en la ficha, usa null en ese campo (o una lista vacía para acordes/notas). No inventes datos que no estén presentes.
            - Responde solo con el JSON.
            TEXTO;
    }

    protected function colorDesdeNombre(string $nombre): string
    {
        $hash = crc32(mb_strtolower($nombre));
        $hue = $hash % 360;

        return $this->hslToHex($hue, 65, 55);
    }

    protected function hslToHex(int $h, int $s, int $l): string
    {
        $s /= 100;
        $l /= 100;

        $c = (1 - abs(2 * $l - 1)) * $s;
        $x = $c * (1 - abs(fmod($h / 60, 2) - 1));
        $m = $l - $c / 2;

        [$r, $g, $b] = match (true) {
            $h < 60 => [$c, $x, 0],
            $h < 120 => [$x, $c, 0],
            $h < 180 => [0, $c, $x],
            $h < 240 => [0, $x, $c],
            $h < 300 => [$x, 0, $c],
            default => [$c, 0, $x],
        };

        return sprintf(
            '#%02X%02X%02X',
            (int) round(($r + $m) * 255),
            (int) round(($g + $m) * 255),
            (int) round(($b + $m) * 255),
        );
    }
}
