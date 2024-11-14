<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bateria extends Model
{
    use HasFactory;
    protected $fillable = ['codigo','marca','tipo', 'voltaje', 'amperios_hora', 'precio'];
}
