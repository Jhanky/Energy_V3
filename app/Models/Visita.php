<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visita extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'NIC',
        'telefono',
        'departamento',
        'ciudad',
        'direccion',
        'ancho',
        'largo',
        'tipo_superficie',
        'notas_observaciones',
        'notas_soporte_tejado',
        'refuerzo',
        'sobre_estructura',
        'opcion_1',
        'distancia_1',
        'opcion_2',
        'distancia_2',
        'opcion_3',
        'distancia_3',
        'notas_observaciones_bajantes',
        'foto_techo',
        'foto_soporte',
        'foto_bajante',
        'foto_inversor',
        'foto_tablero',
        'distancia_tfv',
        'tipo_red',
        'espacio_breaker_si',
        'espacio_breaker_no',
        'espacio_ct_si',
        'espacio_ct_no',
        'calibre_cable',
        'totalizador',
        'tipo_medidor',
        'tipo_medicion',
    ];

    // Convierte campos JSON en arrays al acceder a ellos
    protected $casts = [
        'foto_techo' => 'array',
        'foto_soporte' => 'array',
        'foto_bajante' => 'array',
        'foto_inversor' => 'array',
        'foto_tablero' => 'array',
    ];
}
