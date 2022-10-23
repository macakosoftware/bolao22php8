<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJogadoresUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jogadores_usuarios', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_jogador');
            $table->unsignedInteger('id_user');
            $table->timestamps();
            
            $table->foreign('id_jogador')->references('id')->on('jogadores');
            $table->foreign('id_user')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jogadores_usuarios');
    }
}
