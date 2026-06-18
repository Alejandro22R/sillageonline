<?php

namespace App\Filament\Admin\Resources\Cuotas\Pages;

use App\Filament\Admin\Resources\Cuotas\CuotaResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\Page;

class ListCuotas extends Page
{
    protected static string $resource = CuotaResource::class;

    protected string $view = 'filament.admin.resources.cuotas.list-cuotas';

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->label('Registrar cuota'),
        ];
    }
}