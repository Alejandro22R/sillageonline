<?php

namespace App\Filament\Admin\Resources\DetalleCompras;

use App\Filament\Admin\Resources\DetalleCompras\Pages\CreateDetalleCompra;
use App\Filament\Admin\Resources\DetalleCompras\Pages\EditDetalleCompra;
use App\Filament\Admin\Resources\DetalleCompras\Pages\ListDetalleCompras;
use App\Filament\Admin\Resources\DetalleCompras\Pages\ViewDetalleCompra;
use App\Filament\Admin\Resources\DetalleCompras\Schemas\DetalleCompraForm;
use App\Filament\Admin\Resources\DetalleCompras\Schemas\DetalleCompraInfolist;
use App\Filament\Admin\Resources\DetalleCompras\Tables\DetalleComprasTable;
use App\Models\DetalleCompra;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class DetalleCompraResource extends Resource
{
    protected static ?string $model = DetalleCompra::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static ?string $navigationLabel = 'Detalle de Compras';

    protected static ?string $modelLabel = 'Detalle de Compra';

    protected static ?string $pluralModelLabel = 'Detalles de Compra';

    protected static string|UnitEnum|null $navigationGroup = 'Compras';

    protected static ?int $navigationSort = 20;

    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Schema $schema): Schema
    {
        return DetalleCompraForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return DetalleCompraInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DetalleComprasTable::configure($table);
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
            'index' => ListDetalleCompras::route('/'),
            'create' => CreateDetalleCompra::route('/create'),
            'view' => ViewDetalleCompra::route('/{record}'),
            'edit' => EditDetalleCompra::route('/{record}/edit'),
        ];
    }
}
