<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    // Forzamos el nombre de la tabla si Laravel creó 'proveedors'
    protected $table = 'proveedores';

    protected $fillable = ['nombre', 'rif', 'contacto', 'direccion'];
}
