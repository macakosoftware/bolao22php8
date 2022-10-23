<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddQtPosicaoHistoricosRankingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('historicos_rankings', function (Blueprint $table) {
            $table->unsignedInteger('qt_posicao');
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
            $table->dropColumn('qt_posicao');
        });
    }
}
