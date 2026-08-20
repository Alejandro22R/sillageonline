<?php

namespace App\Filament\Admin\Resources\Cuotas;

use App\Filament\Admin\Resources\Cuotas\Pages\CreateCuota;
use App\Filament\Admin\Resources\Cuotas\Pages\EditCuota;
use App\Filament\Admin\Resources\Cuotas\Pages\ListCuotas;
use App\Filament\Admin\Resources\Cuotas\Schemas\CuotaForm;
use App\Models\Cuota;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use UnitEnum;

class CuotaResource extends Resource
{
    protected static ?string $model = Cuota::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-credit-card';

    protected static ?string $navigationLabel = 'Cuotas';

    protected static string|UnitEnum|null $navigationGroup = 'Ventas';

    protected static ?int $navigationSort = 40;

    protected static ?string $recordTitleAttribute = 'Cuota';

    protected static ?string $modelLabel = 'Abono';

    protected static ?string $pluralModelLabel = 'Cuotas';

    /**
     * El índice ("Cuotas") no usa el Table Builder: es una vista propia de
     * tarjetas (ver Pages\ListCuotas). form() sigue existiendo para el
     * fallback de Create/Edit de un abono suelto.
     */
    public static function form(Schema $schema): Schema
    {
        return CuotaForm::configure($schema);
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
            'edit' => EditCuota::route('/{record}/edit'),
        ];
    }
}
