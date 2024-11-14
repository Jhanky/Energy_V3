<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    public $timestamps = true;

    // Define la relación belongsTo con el modelo User
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user'); // 'id_user' es la FK en la tabla clientes
    }
    use HasFactory;
    protected $fillable = [
        'id',
        'NIC',
        'id_user',
        'tipo_cliente',
        'nombre',
        'departamento',
        'ciudad',
        'direccion',
        'consumo_actual',
        'tarifa',
    ];
}
