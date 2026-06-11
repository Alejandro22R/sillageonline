<?php

namespace App\Filament\Admin\Resources\Cuotas\Pages;

use App\Filament\Admin\Resources\Cuotas\CuotaResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewCuota extends ViewRecord
{
    protected static string $resource = CuotaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
