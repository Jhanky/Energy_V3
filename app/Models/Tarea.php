<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tarea extends Model
{
    use HasFactory;

    // Definir la tabla si no sigue el estándar
    protected $table = 'tareas';

    // Los campos que se pueden asignar de forma masiva
    protected $fillable = ['titulo', 'descripcion', 'posicion', 'lista_tablero_id'];

    // Relación con la lista del tablero
    public function lista()
    {
        return $this->belongsTo(ListaTablero::class, 'lista_tablero_id');
    }
}
