<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orden extends Model
{
    use HasFactory;

    protected $table = 'ordenes';

    protected $fillable = [
        'tipo',
        'id_cliente',
        'direccion',
        'fecha_hora',
        'observaciones',
        'tecnicos_seleccionados',
    ];
}
