<?php

namespace App\Filament\Admin\Resources\Chords;

use App\Filament\Admin\Resources\Chords\Pages;
use App\Models\Chord;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class ChordResource extends Resource
{
    protected static ?string $model = Chord::class;

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-swatch';

    protected static ?string $navigationLabel = 'Acordes';

    protected static ?string $modelLabel = 'Acorde';

    protected static ?string $pluralModelLabel = 'Acordes';

    protected static string | UnitEnum | null $navigationGroup = 'Catálogo';

    protected static ?int $navigationSort = 30;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nombre del acorde')
                    ->placeholder('Ej. Amaderado, Dulce, Afrutado')
                    ->required()
                    ->maxLength(255),

                ColorPicker::make('color')
                    ->label('Color de la barra')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ColorColumn::make('color')
                    ->label('Color'),

                TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Creado')
                    ->dateTime('d/m/Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index'  => Pages\ListChords::route('/'),
            'create' => Pages\CreateChord::route('/create'),
            'edit'   => Pages\EditChord::route('/{record}/edit'),
        ];
    }
}