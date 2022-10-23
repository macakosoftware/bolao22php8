<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistCreditosUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hist_creditos_usuarios', function (Blueprint $table) {
            $table->increments('id');
            $table->char('tp_movimento');
            $table->decimal('vl_movimento',10,2);
            $table->string('ds_observacao');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hist_creditos_usuarios');
    }
}
