<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePoolsVotosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pools_votos', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_pool');
            $table->unsignedInteger('id_user');
            $table->char('cd_valor');
            $table->timestamps();
            
            $table->foreign('id_pool')->references('id')->on('pools');
            $table->foreign('id_user')->references('id')->on('users');
            //$table->foreign('cd_valor')->references('cd_valor')->on('pools_valores');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pools_votos');
    }
}
