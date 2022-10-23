<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFasesRankingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fases_rankings', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_ranking_composto');
            $table->unsignedInteger('id_ranking_simples');
            $table->foreign('id_ranking_composto')->references('id')->on('tipos_rankings');
            $table->foreign('id_ranking_simples')->references('id')->on('tipos_rankings');
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
        Schema::dropIfExists('fases_rankings');
    }
}
