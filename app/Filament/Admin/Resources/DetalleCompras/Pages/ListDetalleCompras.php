<?php

namespace App\Filament\Admin\Resources\DetalleCompras\Pages;

use App\Filament\Admin\Resources\DetalleCompras\DetalleCompraResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListDetalleCompras extends ListRecords
{
    protected static string $resource = DetalleCompraResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
