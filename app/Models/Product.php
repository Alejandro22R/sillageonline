<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;


class Product extends Model
{
    // 1. Aquí solo van los nombres puros de las columnas transitables
    protected $fillable = [
        'name',
        'slug',
        'marca_perfume',
        'description',
        'wholesale_price',
        'retail_price',
        'metodo_pago', // <-- Ahora solo el nombre de la columna limpia
        'precio_divisa',
        'stock',
        'image',
        'is_exclusive',
        'is_offer',
        'offer_price'
    ];

    // 2. ESTA PROPIEDAD DEBE IR AFUERA. Esto es lo que le dice a Laravel que lo guarde como array/JSON
    protected $casts = [
        'metodo_pago' => 'array',
    ];

    /**
     * Genera el slug automáticamente a partir del name
     * cada vez que se crea o actualiza un producto, si no
     * se especificó uno manualmente.
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
        });
    }

    /**
     * Permite usar el slug en lugar del id en las rutas
     * con Route Model Binding (Route::get('/store/{product}', ...)).
     * Si sigues usando {slug} manual en tu componente Livewire
     * (como en el ProductDetail que armamos), esto no es
     * obligatorio, pero no está de más tenerlo.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Relación con los detalles de compras.
     */
    public function detallesCompra(): HasMany
    {
        return $this->hasMany(DetalleCompra::class, 'product_id');
    }

    public function notes(): BelongsToMany
    {
        return $this->belongsToMany(Note::class, 'product_note');
    }

    public function topNotes(): BelongsToMany
    {
        return $this->notes()->where('type', 'top');
    }

    public function heartNotes(): BelongsToMany
    {
        return $this->notes()->where('type', 'heart');
    }

    public function baseNotes(): BelongsToMany
    {
        return $this->notes()->where('type', 'base');
    }

    public function chords(): BelongsToMany
    {
        return $this->belongsToMany(Chord::class, 'product_chord')
            ->withPivot('intensity')
            ->withTimestamps();
    }
}