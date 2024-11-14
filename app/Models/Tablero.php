<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tablero extends Model
{
    use HasFactory;

    // Definir la tabla si no sigue el estándar
    protected $table = 'tableros';

    // Los campos que se pueden asignar de forma masiva
    protected $fillable = ['nombre', 'proyecto_id'];

    // Relación con proyecto
    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class);
    }

    // Relación con listas
    public function listas()
    {
        return $this->hasMany(ListaTablero::class);
    }
}
