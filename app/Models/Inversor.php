<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inversor extends Model
{
    use HasFactory;
    protected $fillable = ['codigo','marca','modelo', 'descripcion', 'tipo_red', 'poder', 'tipo', 'precio'];
}
