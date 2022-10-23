<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBadgesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('badges', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ds_nome');
            $table->unsignedInteger('cd_ranking');
            $table->boolean('id_posicao');
            $table->unsignedInteger('nr_posicao');
            $table->boolean('id_maior_pontuacao');
            $table->boolean('id_placares_cheios');
            $table->boolean('id_resultados');            
            $table->string('ds_link_badge');            
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
        Schema::dropIfExists('badges');
    }
}
