<?php

namespace App\Filament\Admin\Resources\Chords\Pages;

use App\Filament\Admin\Resources\Chords\ChordResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListChords extends ListRecords
{
    protected static string $resource = ChordResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
