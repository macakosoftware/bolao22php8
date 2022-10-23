<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransacoesPropostasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transacoes_propostas', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_transacao');
            $table->unsignedInteger('id_user_proposta');
            $table->unsignedInteger('id_jogador');
            $table->decimal('vl_proposta',8,2);
            $table->char('cd_status');
            $table->timestamps();
            
            $table->foreign('id_transacao')->references('id')->on('transacoes_figurinhas');
            $table->foreign('id_user_proposta')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transacoes_propostas');
    }
}
