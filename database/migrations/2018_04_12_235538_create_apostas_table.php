<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApostasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apostas', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_jogo');
            $table->unsignedInteger('qt_gols_selecao1');
            $table->unsignedInteger('qt_gols_selecao2');
            $table->unsignedInteger('id_user');
            $table->timestamps();
            
            $table->foreign('id_jogo')->references('id')->on('jogos');
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
        Schema::dropIfExists('apostas');
    }
}
