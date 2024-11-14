<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Panel_solar extends Model
{
    use HasFactory;
    protected $fillable = ['codigo', 'marca','modelo', 'descripcion', 'poder', 'precio'];
}
