<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificacoesAlbumTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notificacoes_album', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_user');
            $table->char('tp_notificacao');
            $table->unsignedInteger('id_transacao');
            $table->unsignedInteger('id_proposta');
            $table->char('tp_resposta');
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
        Schema::dropIfExists('notificacoes_album');
    }
}
