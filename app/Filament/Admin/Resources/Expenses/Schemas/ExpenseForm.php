<?php

namespace App\Filament\Admin\Resources\Expenses\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ExpenseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('description')
                    ->label('Descripción del Gasto')
                    ->placeholder('Ej: Compra de 12 unidades de Club de Nuit')
                    ->required()
                    ->maxLength(255),

                TextInput::make('amount')
                    ->label('Monto Pagado')
                    ->numeric()
                    ->prefix('$')
                    ->required(),

                DatePicker::make('expense_date')
                    ->label('Fecha del Movimiento')
                    ->default(now())
                    ->required(),

                Select::make('category')
                    ->label('Categoría del Gasto')
                    ->options([
                        'Mercancía' => 'Compra de Inventario',
                        'Publicidad' => 'Marketing e Instagram',
                        'Envío' => 'Logística (Delivery)',
                        'Operaciones' => 'Servicios o Alquiler',
                        'Otros' => 'Otros gastos',
                    ])
                    ->required()
                    ->native(false), // Esto hace que el diseño del selector sea más moderno
            ]);
    }
}