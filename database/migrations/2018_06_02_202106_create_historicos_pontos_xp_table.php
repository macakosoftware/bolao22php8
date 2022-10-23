<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistoricosPontosXpTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('historicos_pontos_xp', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_user');
            $table->char('tp_transacao');
            $table->date('dt_transacao');
            $table->string('ds_transacao');
            $table->decimal('vl_transacao',6,2);
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
        Schema::dropIfExists('historicos_pontos_xp');
    }
}
