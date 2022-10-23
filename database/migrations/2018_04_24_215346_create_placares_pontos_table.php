<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlacaresPontosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('placares_pontos', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('cd_placar');
            $table->unsignedTinyInteger('nr_dif_inicial');
            $table->unsignedTinyInteger('nr_dif_final');
            $table->decimal('qt_pontos1', 4, 2);
            $table->decimal('qt_pontos2', 4, 2);
            $table->timestamps();
            
            $table->foreign('cd_placar')->references('id')->on('placares');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('placares_pontos');
    }
}
