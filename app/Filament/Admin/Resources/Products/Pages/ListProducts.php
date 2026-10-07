<?php

namespace App\Filament\Admin\Resources\Products\Pages;

use App\Filament\Admin\Resources\Products\ProductResource;
use App\Models\Product; // <-- Importante para consultar el modelo
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions\Action;
use Barryvdh\DomPDF\Facade\Pdf;

class ListProducts extends ListRecords
{
    protected static string $resource = ProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),

            // Escanea un código de barras: si ya hay un producto con ese
            // código, abre su edición; si no, abre "Crear" con el código
            // precargado para asignarle los datos y el precio.
            Action::make('escanearProducto')
                ->label('Buscar por código de barras')
                ->icon('heroicon-o-camera')
                ->color('gray')
                ->modalHeading('Escanear código de barras')
                ->modalContent(view('filament.pages.escaner-busqueda-producto'))
                ->modalSubmitAction(false)
                ->modalCancelActionLabel('Cerrar'),

            // Botón para descargar el PDF con todos los registros de la tabla products
            Action::make('downloadProductsPdf')
                ->label('Descargar Listado PDF')
                ->icon('heroicon-o-document-arrow-down')
                ->color('success')
                ->action(function () {
                    // Extraemos todos los productos de la base de datos
                    $products = Product::all();

                    // Cargamos la vista y le pasamos la variable $products
                    $pdf = Pdf::loadView('pdf.products-report', compact('products'));

                    // Configuramos la hoja horizontal (opcional, por si la tabla es ancha)
                    $pdf->setPaper('a4', 'landscape');

                    return response()->streamDownload(function () use ($pdf) {
                        echo $pdf->output();
                    }, 'reporte-productos-' . date('Y-m-d') . '.pdf');
                }),
        ];
    }

    /**
     * Llamado desde el JS del escáner (Html5Qrcode) apenas detecta un
     * código. Si ya existe un producto con ese código de barras, va
     * directo a editarlo; si no, abre "Crear producto" con el código
     * precargado para terminar de cargarlo y asignarle precio.
     */
    public function irABarcode(string $codigo): mixed
    {
        $producto = Product::where('codigo_barras', $codigo)->first();

        if ($producto) {
            return redirect(ProductResource::getUrl('edit', ['record' => $producto]));
        }

        return redirect(ProductResource::getUrl('create', ['codigo_barras' => $codigo]));
    }
}
