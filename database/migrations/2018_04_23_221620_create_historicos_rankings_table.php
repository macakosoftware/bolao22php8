<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistoricosRankingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('historicos_rankings', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('dt_hr_ranking');
            $table->unsignedInteger('cd_ranking');
            $table->unsignedInteger('id_user');
            $table->unsignedInteger('qt_acertos_cheio');
            $table->unsignedInteger('qt_acertos_parcial');
            $table->unsignedInteger('qt_acertos_resultado');
            $table->unsignedInteger('qt_pontos');
            $table->timestamps();
            
            $table->foreign('cd_ranking')->references('id')->on('tipos_rankings');
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
        Schema::dropIfExists('historicos_rankings');
    }
}
