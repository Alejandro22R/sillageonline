<?php

namespace App\Filament\Admin\Pages;

use Filament\Pages\Page;
use App\Models\Product;

class CatalogoPrecios extends Page
{
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-currency-dollar'; 
    protected static string | \UnitEnum | null $navigationGroup = 'Catálogos'; 
    protected static ?string $title = 'Catálogo de Precios';

    protected string $view = 'filament.admin.pages.catalogo-precios';

    // Propiedad vinculada al buscador
    public $search = '';

    protected function getViewData(): array
    {
        return [
            'products' => Product::where('stock', '>', 0)
                ->when($this->search, function ($query) {
                    $query->where('name', 'like', '%' . $this->search . '%');
                })
                ->get(), 
        ];
    }
}