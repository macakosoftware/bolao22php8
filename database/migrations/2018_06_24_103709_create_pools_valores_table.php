<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePoolsValoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pools_valores', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_pool');
            $table->char('cd_valor');
            $table->string('ds_valor');
            $table->timestamps();
            
            $table->foreign('id_pool')->references('id')->on('pools');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pools_valores');
    }
}
