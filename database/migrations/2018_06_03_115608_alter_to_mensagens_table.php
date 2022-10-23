<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterToMensagensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mensagens', function (Blueprint $table) {
            $table->dropForeign(['id_user_to']);
            $table->dropColumn('id_user_to');
            $table->unsignedInteger('id_mensagem_relacionada');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mensagens', function (Blueprint $table) {
            $table->unsignedInteger('id_user_to');
            $table->foreign('id_user_to')->references('id')->on('users');
            $table->dropColumn('id_mensagem_relacionada');
        });
    }
}
