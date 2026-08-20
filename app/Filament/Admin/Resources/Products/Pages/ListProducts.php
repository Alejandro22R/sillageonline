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
}
