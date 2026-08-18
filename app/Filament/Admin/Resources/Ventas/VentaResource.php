<?php

namespace App\Filament\Admin\Resources\Ventas;

use App\Filament\Admin\Resources\Ventas\Pages\CreateVenta;
use App\Filament\Admin\Resources\Ventas\Pages\EditVenta;
use App\Filament\Admin\Resources\Ventas\Pages\ListVentas;
use App\Filament\Admin\Resources\Ventas\Pages\ViewVenta;
use App\Filament\Admin\Resources\Ventas\Schemas\VentaForm;
use App\Filament\Admin\Resources\Ventas\Schemas\VentaInfolist;
use App\Filament\Admin\Resources\Ventas\Tables\VentasTable;
use App\Models\Venta;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class VentaResource extends Resource
{
    protected static ?string $model = Venta::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-shopping-cart';

    protected static string|UnitEnum|null $navigationGroup = 'Ventas';

    protected static ?int $navigationSort = 10;

    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Schema $schema): Schema
    {
        return VentaForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return VentaInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return VentasTable::configure($table);
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
            'index' => ListVentas::route('/'),
            'create' => CreateVenta::route('/create'),
            'view' => ViewVenta::route('/{record}'),
            'edit' => EditVenta::route('/{record}/edit'),
        ];
    }
}
