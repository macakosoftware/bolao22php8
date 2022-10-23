<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPontosToHistoricoRankingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('historicos_rankings', function (Blueprint $table) {
            $table->unsignedInteger('qt_pontos_resultado');
            $table->unsignedInteger('qt_pontos_placar_cheio');
            $table->unsignedInteger('qt_pontos_placar_parcial');
            $table->unsignedInteger('qt_pontos_maior');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('historicos_rankings', function (Blueprint $table) {
            $table->dropColumn('qt_pontos_resultado');
            $table->dropColumn('qt_pontos_placar_cheio');
            $table->dropColumn('qt_pontos_placar_parcial');
            $table->dropColumn('qt_pontos_maior');
        });
    }
}
