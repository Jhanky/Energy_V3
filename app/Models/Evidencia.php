<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evidencia extends Model
{
    use HasFactory;

    protected $fillable = [
        'orden_id',
        'observaciones',
        'fotos'
    ];

    protected $casts = [
        'fotos' => 'array'
    ];

    public function orden()
    {
        return $this->belongsTo(Orden::class);
    }
}
