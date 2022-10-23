<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterPontosRankingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rankings', function (Blueprint $table) {
            $table->decimal('qt_pontos',4,2)->change();
            $table->decimal('qt_pontos_resultado',4,2)->change();
            $table->decimal('qt_pontos_placar_cheio',4,2)->change();
            $table->decimal('qt_pontos_placar_parcial',4,2)->change();
            $table->decimal('qt_pontos_maior',4,2)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rankings', function (Blueprint $table) {
            $table->unsignedInteger('qt_pontos')->change();
            $table->unsignedInteger('qt_pontos_resultado')->change();
            $table->unsignedInteger('qt_pontos_placar_cheio')->change();
            $table->unsignedInteger('qt_pontos_placar_parcial')->change();
            $table->unsignedInteger('qt_pontos_maior')->change();
        });
    }
}
