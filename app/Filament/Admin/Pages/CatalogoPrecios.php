<?php

namespace App\Filament\Admin\Pages;

use Filament\Pages\Page;
use App\Models\Product;

class CatalogoPrecios extends Page
{
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-tag';
    protected static string | \UnitEnum | null $navigationGroup = 'Catálogo';
    protected static ?int $navigationSort = 40;
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