<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropostasJogadoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('propostas_jogadores', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_proposta');
            $table->unsignedInteger('id_jogador');
            $table->timestamps();
            
            $table->foreign('id_proposta')->references('id')->on('transacoes_propostas');
            $table->foreign('id_jogador')->references('id')->on('jogadores');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('propostas_jogadores');
    }
}
