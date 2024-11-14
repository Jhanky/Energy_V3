<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListaTablero extends Model
{
    use HasFactory;

    // Definir la tabla si no sigue el estándar
    protected $table = 'listas_tablero';

    // Los campos que se pueden asignar de forma masiva
    protected $fillable = ['nombre', 'posicion', 'tablero_id'];

    // Relación con el tablero
    public function tablero()
    {
        return $this->belongsTo(Tablero::class);
    }

    // Relación con las tareas
    public function tareas()
    {
        return $this->hasMany(Tarea::class);
    }
}
