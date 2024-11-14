<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presupuesto extends Model
{
    use HasFactory;
    protected $fillable = ['valor_conductor_fotovoltaico', 'codigo_propuesta','nombre_proyecto', 'id_panel', 'numero_paneles'];
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'id_cliente', 'NIC');
    }
    public function estado()
    {
        return $this->belongsTo(Estado::class, 'id_estado');
    }

    public function panelSolar()
    {
        return $this->belongsTo(Panel_solar::class, 'id_panel');
    }

    public function bateria()
    {
        return $this->belongsTo(Bateria::class, 'id_bateria');
    }

    public function inversor()
    {
        return $this->belongsTo(Inversor::class, 'id_inversor');
    }

    public function inversor2()
    {
        return $this->belongsTo(Inversor::class, 'id_inversor_2');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
