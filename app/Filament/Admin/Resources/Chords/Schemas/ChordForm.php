<?php

namespace App\Filament\Admin\Resources\Chords\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ChordForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('color')
                    ->required(),
            ]);
    }
}
