<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePresupuestosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('presupuestos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_cliente'); 
            $table->unsignedBigInteger('id_panel');
            $table->unsignedBigInteger('id_inversor');
            $table->unsignedBigInteger('id_bateria');
            $table->foreign('id_cliente')->references('NIC')->on('clientes')->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->foreign('id_panel')->references('id')->on('panel_solars')->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->foreign('id_inversor')->references('id')->on('inversors')->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->foreign('id_bateria')->references('id')->on('baterias')->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->string('tipo_sistema');
            $table->float('numero_paneles');
            $table->float('numero_baterias');
            $table->float('numero_inversores');
            $table->float('valor_material_electrico');
            $table->float('valor_tramites');            
            $table->float('valor_estructura');
            $table->float('mano_obra');
            $table->float('valor_gestion_comercial');
            $table->float('valor_abministracion');
            $table->float('valor_imprevisto');
            $table->float('valor_utilidad');
            $table->float('valor_retencion');
            $table->double('latitud')->nullable();
            $table->double('longitud')->nullable();
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('presupuestos');
    }
}
