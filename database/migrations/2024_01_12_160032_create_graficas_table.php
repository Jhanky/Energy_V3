<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGraficasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('graficas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('ruta_imagen');
            $table->unsignedBigInteger('id_presupuesto');
            $table->timestamps();
    
            // Definir la llave foránea
            $table->foreign('id_presupuesto')->references('id')->on('presupuestos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('graficas');
    }
}
