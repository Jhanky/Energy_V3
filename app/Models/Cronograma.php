<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cronograma extends Model
{
    use HasFactory;
    protected $fillable = ['id_propuesta', 'firma_de_contrato_inicio','firma_de_contrato_fin', 'estudio_de_conexion_ante_operadore_de_red_inicio', 'estudio_de_conexion_ante_operadore_de_red_fin', 'replanteo_del_proyecto_inicio', 'replanteo_del_proyecto_fin', 'reunion_socilaización_del_proyecto_inicio', 'reunion_socilaización_del_proyecto_fin', 'montaje_paneles_solares_inicio', 'montaje_paneles_solares_fin', 'montaje_inversor_inicio', 'montaje_inversor_fin', 'conexionado_inicio', 'conexionado_fin', 'pruebas_de_conexion_inicio', 'pruebas_de_conexion_fin', 'puesta_en_marcha_inicio', 'puesta_en_marcha_fin', 'certificado_RETIE_inicio', 'certificado_RETIE_fin', 'visita_operador_de_red_inicio', 'visita_operador_de_red_fin', 'instalacion_medidor_bidireccional_inicio', 'instalacion_medidor_bidireccional_fin'];
}
