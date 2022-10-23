<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropIdJogadorTransacoesPropostasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transacoes_propostas', function (Blueprint $table) {
            $table->dropColumn('id_jogador');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transacoes_propostas', function (Blueprint $table) {
            $table->unsignedInteger('id_jogador');
        });
    }
}
