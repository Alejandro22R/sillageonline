<?php

namespace App\Filament\Forms\Components;

use Filament\Forms\Components\Field;
use Illuminate\Support\Str;

/**
 * Campo de texto con un botón "Escanear" que abre la cámara del
 * dispositivo (vía la librería JS html5-qrcode) y lee códigos de
 * barras (EAN-13, UPC-A, CODE-128, etc.) y QR, rellenando el campo
 * con el texto detectado. El usuario también puede escribir el código
 * a mano si lo prefiere, o si más adelante se usa una pistola lectora
 * USB (que simplemente "escribe" el código y un Enter).
 */
class BarcodeScannerInput extends Field
{
    protected string $view = 'filament.forms.components.barcode-scanner-input';

    protected string | \Closure | null $scannerPlaceholder = 'Escanea o escribe el código de barras';

    public function scannerPlaceholder(string | \Closure | null $placeholder): static
    {
        $this->scannerPlaceholder = $placeholder;

        return $this;
    }

    public function getScannerPlaceholder(): ?string
    {
        return $this->evaluate($this->scannerPlaceholder);
    }

    protected ?string $lectorId = null;

    /**
     * Memoizado: si se generara un id distinto cada vez que la vista
     * llama a $getLectorId(), el <div> de la cámara y el script que lo
     * referencia dejarían de coincidir.
     */
    public function getLectorId(): string
    {
        if ($this->lectorId === null) {
            $this->lectorId = 'lector-' . Str::replace('.', '-', $this->getStatePath()) . '-' . Str::random(6);
        }

        return $this->lectorId;
    }
}
