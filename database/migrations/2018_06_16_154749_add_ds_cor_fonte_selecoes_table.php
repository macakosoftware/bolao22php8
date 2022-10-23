<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDsCorFonteSelecoesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('selecoes', function (Blueprint $table) {
            $table->string('ds_cor');
            $table->string('ds_fonte');
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
            $table->dropColumn('ds_cor');
            $table->dropColumn('ds_fonte');
        });
    }
}
