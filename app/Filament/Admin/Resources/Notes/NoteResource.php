<?php

namespace App\Filament\Admin\Resources\Notes;

use App\Filament\Admin\Resources\Notes\Pages;
use App\Models\Note;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use UnitEnum;

class NoteResource extends Resource
{
    protected static ?string $model = Note::class;

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-sparkles';

    protected static ?string $navigationLabel = 'Notas Olfativas';

    protected static ?string $modelLabel = 'Nota';

    protected static ?string $pluralModelLabel = 'Notas Olfativas';

    protected static string | UnitEnum | null $navigationGroup = 'Catálogo';

    protected static ?int $navigationSort = 20;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nombre de la nota')
                    ->placeholder('Ej. Bergamota, Vainilla, Almizcle')
                    ->required()
                    ->maxLength(255),

                Select::make('type')
                    ->label('Tipo de nota')
                    ->options([
                        'top'   => 'Salida (Top)',
                        'heart' => 'Corazón (Heart)',
                        'base'  => 'Fondo (Base)',
                    ])
                    ->required()
                    ->native(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable()
                    ->sortable(),

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
                    })
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Creado')
                    ->dateTime('d/m/Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->label('Tipo')
                    ->options([
                        'top'   => 'Salida',
                        'heart' => 'Corazón',
                        'base'  => 'Fondo',
                    ]),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('name');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListNotes::route('/'),
            'create' => Pages\CreateNote::route('/create'),
            'edit'   => Pages\EditNote::route('/{record}/edit'),
        ];
    }
}