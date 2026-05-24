<?php

namespace App\Filament\Admin\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select; // <--- IMPORTANTE: Añade esta línea
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),

                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required(),

                DateTimePicker::make('email_verified_at'),

                TextInput::make('password')
                    ->password()
                    ->required(fn ($context) => $context === 'create') // Solo obligatorio al crear
                    ->dehydrated(fn ($state) => filled($state)),      // No borra la clave si se deja vacía al editar


                Select::make('roles')
                    ->relationship('roles', 'name')
                    ->multiple()
                    ->preload()
                    ->searchable()
                    ->required(),
            ]);
    }
}
