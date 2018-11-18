<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDatosHistoricosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('datos_historicos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tiker', 45); 
            $table->string('date', 45)->nullable();
            $table->string('open', 45)->nullable();
            $table->string('high', 45)->nullable();
            $table->string('low', 45)->nullable();
            $table->string('close', 45)->nullable();
            $table->string('adjClose', 45)->nullable();
            $table->string('volume', 45)->nullable();
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
