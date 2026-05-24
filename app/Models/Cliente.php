<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    // AQUÍ ACLARAS EL NOMBRE DE LA TABLA
    protected $table = 'clientes';

    protected $fillable = [
        'nombre',
        'apellido',
        'cedula',
        'telefono',
        'correo',
        'direccion',
        'genero'
    ];
}
