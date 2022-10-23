<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddVlJoiaMovimentosPagamentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('movimentos_pagamentos', function (Blueprint $table) {
            $table->decimal('vl_joia',10,2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('movimentos_pagamentos', function (Blueprint $table) {
            $table->dropColumn('vl_joia');
        });
    }
}
