<?php

namespace App\Filament\Admin\Resources\Proveedors;

use App\Filament\Admin\Resources\Proveedors\Pages\CreateProveedor;
use App\Filament\Admin\Resources\Proveedors\Pages\EditProveedor;
use App\Filament\Admin\Resources\Proveedors\Pages\ListProveedors;
use App\Filament\Admin\Resources\Proveedors\Pages\ViewProveedor;
use App\Filament\Admin\Resources\Proveedors\Schemas\ProveedorForm;
use App\Filament\Admin\Resources\Proveedors\Schemas\ProveedorInfolist;
use App\Filament\Admin\Resources\Proveedors\Tables\ProveedorsTable;
use App\Models\Proveedor;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class ProveedorResource extends Resource
{
    protected static ?string $model = Proveedor::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-building-storefront';

    protected static ?string $navigationLabel = 'Proveedores';

    protected static ?string $modelLabel = 'Proveedor';

    protected static ?string $pluralModelLabel = 'Proveedores';

    protected static string|UnitEnum|null $navigationGroup = 'Compras';

    protected static ?int $navigationSort = 30;

    protected static ?string $recordTitleAttribute = 'nombre';

    public static function form(Schema $schema): Schema
    {
        return ProveedorForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ProveedorInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ProveedorsTable::configure($table);
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
            'index' => ListProveedors::route('/'),
            'create' => CreateProveedor::route('/create'),
            'view' => ViewProveedor::route('/{record}'),
            'edit' => EditProveedor::route('/{record}/edit'),
        ];
    }
}
