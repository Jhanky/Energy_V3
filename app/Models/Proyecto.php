<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proyecto extends Model
{
    use HasFactory;

    // Definir la tabla si no sigue el estándar
    protected $table = 'proyectos';

    // Los campos que se pueden asignar de forma masiva
    protected $fillable = ['nombre', 'descripcion'];

    // Relación con los tableros
    public function tableros()
    {
        return $this->hasMany(Tablero::class);
    }
}
