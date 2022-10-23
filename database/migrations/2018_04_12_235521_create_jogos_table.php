<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJogosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jogos', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_selecao1');
            $table->unsignedInteger('id_selecao2');
            $table->date('dt_jogo');
            $table->time('hr_jogo');
            $table->unsignedInteger('id_estadio');
            $table->unsignedInteger('cd_status');
            $table->unsignedInteger('qt_gols_selecao1');
            $table->unsignedInteger('qt_gols_selecao2');
            $table->unsignedInteger('cd_ranking');
            $table->timestamps();
           
            $table->foreign('id_selecao1')->references('id')->on('selecoes');
            $table->foreign('id_selecao2')->references('id')->on('selecoes');
            $table->foreign('cd_status')->references('id')->on('status_jogos');
            $table->foreign('id_estadio')->references('id')->on('estadios');
            $table->foreign('cd_ranking')->references('id')->on('tipos_rankings');
        });        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jogos');
    }
}
