<?php

namespace App\Filament\Admin\Resources\Products\RelationManagers;

use Filament\Actions\AttachAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DetachAction;
use Filament\Actions\DetachBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ChordsRelationManager extends RelationManager
{
    protected static string $relationship = 'chords';

    protected static ?string $title = 'Acordes';

    /**
     * Este formulario lo usa el botón "Editar" de la tabla: el registro que
     * llega ahí ya es el propio Chord adjunto (no el Product), así que no
     * tiene sentido volver a elegir "qué acorde es" con un Select de
     * relación — eso ya se resolvió al adjuntarlo. Lo único editable por
     * cada adjunto es la intensidad de ese acorde en este producto.
     */
    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('intensity')
                    ->label('Intensidad (%)')
                    ->numeric()
                    ->minValue(1)
                    ->maxValue(100)
                    ->default(50)
                    ->required()
                    ->suffix('%'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                ColorColumn::make('color')
                    ->label('Color'),

                TextColumn::make('name')
                    ->label('Acorde'),

                TextColumn::make('pivot.intensity')
                    ->label('Intensidad')
                    ->suffix('%')
                    ->sortable(query: fn ($query, string $direction) => $query->orderBy('product_chord.intensity', $direction)),
            ])
            ->headerActions([
                AttachAction::make()
                    ->preloadRecordSelect()
                    ->schema(fn (AttachAction $action): array => [
                        $action->getRecordSelect(),
                        TextInput::make('intensity')
                            ->label('Intensidad (%)')
                            ->numeric()
                            ->minValue(1)
                            ->maxValue(100)
                            ->default(50)
                            ->required(),
                    ]),
            ])
            ->recordActions([
                EditAction::make(),
                DetachAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DetachBulkAction::make(),
                ]),
            ]);
    }
}