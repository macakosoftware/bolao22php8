<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterPontosRankingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rankings', function (Blueprint $table) {
            $table->decimal('qt_pontos',8,2)->change();
            $table->decimal('qt_pontos_resultado',8,2)->change();
            $table->decimal('qt_pontos_placar_cheio',8,2)->change();
            $table->decimal('qt_pontos_placar_parcial',8,2)->change();
            $table->decimal('qt_pontos_maior',8,2)->change();
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
            //
        });
    }
}
