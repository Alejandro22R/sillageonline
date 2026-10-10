<?php

namespace App\Filament\Admin\Resources\Products\Pages;

use App\Filament\Admin\Resources\Products\ProductResource;
use App\Services\FragranticaImportService;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Storage;
use RuntimeException;

class EditProduct extends EditRecord
{
    protected static string $resource = ProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),

            // Carga automática del perfil olfativo (acordes, pirámide,
            // longevidad, estela, día/noche y estaciones) a partir de una
            // captura de la ficha de Fragrantica o de su URL, usando IA,
            // para no tener que transcribirlo todo a mano.
            Action::make('importarFragrantica')
                ->label('Importar de Fragrantica')
                ->icon('heroicon-o-sparkles')
                ->color('gray')
                ->modalHeading('Importar perfil olfativo de Fragrantica')
                ->modalDescription('Pega el link de la ficha en Fragrantica, o sube una captura de pantalla de la ficha (puede ser foto desde el celular). Si tienes las dos, se usa el link.')
                ->schema([
                    TextInput::make('url')
                        ->label('URL de Fragrantica')
                        ->url()
                        ->placeholder('https://www.fragrantica.com/perfume/...'),

                    FileUpload::make('imagen')
                        ->label('O una captura de la ficha')
                        ->image()
                        ->disk('local')
                        ->directory('fragrantica-imports')
                        ->maxSize(10240),
                ])
                ->action(function (array $data) {
                    $this->procesarImportacionFragrantica($data);
                }),

            DeleteAction::make(),
        ];
    }

    protected function procesarImportacionFragrantica(array $data): void
    {
        $url = trim((string) ($data['url'] ?? ''));
        $rutaImagen = $data['imagen'] ?? null;

        if ($url === '' && blank($rutaImagen)) {
            Notification::make()
                ->title('Pega una URL o sube una captura de la ficha.')
                ->warning()
                ->send();

            return;
        }

        try {
            $servicio = new FragranticaImportService();

            if ($url !== '') {
                $datos = $servicio->desdeUrl($url);
            } else {
                $contenido = Storage::disk('local')->get($rutaImagen);
                $mediaType = Storage::disk('local')->mimeType($rutaImagen) ?: 'image/jpeg';
                $datos = $servicio->desdeImagen(base64_encode($contenido), $mediaType);
            }

            $servicio->aplicarAProducto($this->record, $datos);

            Notification::make()
                ->title('Perfil olfativo importado correctamente.')
                ->body('Revisa los Acordes, la Pirámide Olfativa y el Perfil Olfativo: la IA puede equivocarse, así que conviene confirmarlos.')
                ->success()
                ->send();
        } catch (RuntimeException $e) {
            Notification::make()
                ->title('No se pudo importar')
                ->body($e->getMessage())
                ->danger()
                ->send();

            return;
        } finally {
            if (filled($rutaImagen)) {
                Storage::disk('local')->delete($rutaImagen);
            }
        }

        $this->redirect(static::getResource()::getUrl('edit', ['record' => $this->record]));
    }
}
