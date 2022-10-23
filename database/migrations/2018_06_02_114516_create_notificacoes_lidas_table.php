<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificacoesLidasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notificacoes_lidas', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_notificacao');
            $table->unsignedInteger('id_user');
            $table->timestamps();
            
            $table->foreign('id_notificacao')->references('id')->on('notificacoes');
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
        Schema::dropIfExists('notificacoes_lidas');
    }
}
