<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddVencSelecaoPenalJogosTable extends Migration
{
     /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('jogos', function (Blueprint $table) {
            $table->string('ds_selecao1');
            $table->string('ds_selecao2');
            $table->tinyInteger('id_vencedor');
            $table->unsignedInteger('qt_gols_penal_selecao1');
            $table->unsignedInteger('qt_gols_penal_selecao2');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('selecoes', function (Blueprint $table) {
            $table->dropColumn('ds_selecao1');
            $table->dropColumn('ds_selecao2');
            $table->dropColumn('id_vencedor');
            $table->dropColumn('qt_gols_penal_selecao1');
            $table->dropColumn('qt_gols_penal_selecao2');
        });
    }
}
