<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddHandcapJogosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('jogos', function (Blueprint $table) {
            $table->decimal('nr_pontos_handcap1', 4, 2);
            $table->decimal('nr_pontos_handcapX', 4, 2);
            $table->decimal('nr_pontos_handcap2', 4, 2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('jogos', function (Blueprint $table) {
            $table->dropColumn('nr_pontos_handcap1');
            $table->dropColumn('nr_pontos_handcapX');
            $table->dropColumn('nr_pontos_handcap2');
        });
    }
}
