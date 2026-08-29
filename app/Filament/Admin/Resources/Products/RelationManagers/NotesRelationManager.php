<?php

namespace App\Filament\Admin\Resources\Products\RelationManagers;

use Filament\Actions\AttachAction;
use Filament\Actions\DetachAction;
use Filament\Actions\DetachBulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class NotesRelationManager extends RelationManager
{
    protected static string $relationship = 'notes';

    protected static ?string $title = 'Notas Olfativas';

    /**
     * No hay EditAction en la tabla (solo Attach/Detach), así que este
     * formulario no llega a usarse — pero si algún día se agrega, no debe
     * repetir el mismo error que tenía ChordsRelationManager: el registro
     * que llegaría aquí ya es la propia Note adjunta, no el Product, y
     * "notes" no es una relación de Note.
     */
    public function form(Schema $schema): Schema
    {
        return $schema->components([]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('name')
                    ->label('Nota'),

                TextColumn::make('type')
                    ->label('Tipo')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'top' => 'Salida',
                        'heart' => 'Corazón',
                        'base' => 'Fondo',
                        default => $state,
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'top' => 'info',
                        'heart' => 'warning',
                        'base' => 'success',
                        default => 'gray',
                    }),
            ])
            ->headerActions([
                AttachAction::make()
                    ->preloadRecordSelect(),
            ])
            ->recordActions([
                DetachAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DetachBulkAction::make(),
                ]),
            ]);
    }
}