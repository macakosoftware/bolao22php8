<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStatusChaveTiposRankingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tipos_rankings', function (Blueprint $table) {            
            $table->foreign('cd_status')->references('id')->on('status_rankings');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tipos_rankings', function (Blueprint $table) {
            $table->dropForeign('cd_status');
        });
    }
}
