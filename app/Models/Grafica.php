<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grafica extends Model
{
    use HasFactory;

    // Nombre de la tabla
    protected $table = 'graficas';

    // Columnas que se pueden asignar en masa
    protected $fillable = [
        'nombre',
        'ruta_imagen',
        'id_presupuesto'
    ];

    // Definir si los timestamps están habilitados o no (opcional)
    public $timestamps = true;

    // Definir la clave primaria si no es 'id' (opcional)
    protected $primaryKey = 'id';
}