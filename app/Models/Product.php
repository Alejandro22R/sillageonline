<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
    'name', 
    'brand', 
    'retail_price', 
    'image', 
    // Agrega estas líneas:
    'is_exclusive', 
    'is_offer', 
    'offer_price'
];
}
{
    //
}
