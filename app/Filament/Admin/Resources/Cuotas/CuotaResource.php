<?php

namespace App\Filament\Admin\Resources\Cuotas;

use App\Filament\Admin\Resources\Cuotas\Pages\CreateCuota;
use App\Filament\Admin\Resources\Cuotas\Pages\EditCuota;
use App\Filament\Admin\Resources\Cuotas\Pages\ListCuotas;
use App\Filament\Admin\Resources\Cuotas\Pages\ViewCuota;
use App\Filament\Admin\Resources\Cuotas\Schemas\CuotaForm;
use App\Filament\Admin\Resources\Cuotas\Schemas\CuotaInfolist;
use App\Filament\Admin\Resources\Cuotas\Tables\CuotasTable;
use App\Models\Cuota;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class CuotaResource extends Resource
{
    protected static ?string $model = Cuota::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Cuota';

    public static function form(Schema $schema): Schema
    {
        return CuotaForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return CuotaInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CuotasTable::configure($table);
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
            'index' => ListCuotas::route('/'),
            'create' => CreateCuota::route('/create'),
            'view' => ViewCuota::route('/{record}'),
            'edit' => EditCuota::route('/{record}/edit'),
        ];
    }
}
