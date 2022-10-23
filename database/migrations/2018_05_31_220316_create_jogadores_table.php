<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJogadoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jogadores', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_selecao');
            $table->string('ds_selecao');
            $table->string('ds_numero');
            $table->string('ds_nome');
            $table->string('ds_abreviado');
            $table->string('ds_posicao');
            $table->date('dt_nascimento');
            $table->string('ds_time');
            $table->string('ds_valor');
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
        Schema::dropIfExists('jogadores');
    }
}
