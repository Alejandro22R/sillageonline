<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Agrega esta línea:
    protected $fillable = ['name', 'brand', 'description', 'wholesale_price', 'retail_price', 'stock', 'image'];
}
{
    //
}
