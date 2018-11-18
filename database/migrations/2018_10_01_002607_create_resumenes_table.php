<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResumenesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resumenes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre', 150);
            $table->string('tiker', 45); 
            $table->string('cierreAnterior', 45)->nullable();
            $table->string('abrir', 45)->nullable();
            $table->string('oferta', 45)->nullable();
            $table->string('demanda', 45)->nullable();
            $table->string('rangoDiario', 45)->nullable();
            $table->string('rango52Semanas', 45)->nullable();           
            $table->string('volumen', 45)->nullable();
            $table->string('mediaVolumen', 45)->nullable();
            $table->string('tmtm', 45)->nullable();
            $table->string('ttm', 45)->nullable();
            $table->string('fechaBeneficios', 45)->nullable();
            $table->string('prevision', 45)->nullable();
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
        //
    }
}
