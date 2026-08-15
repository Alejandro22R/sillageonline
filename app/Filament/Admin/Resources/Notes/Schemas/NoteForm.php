<?php

namespace App\Filament\Admin\Resources\Notes\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class NoteForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                Select::make('type')
                    ->options(['top' => 'Top', 'heart' => 'Heart', 'base' => 'Base'])
                    ->required(),
            ]);
    }
}
