<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBadgeHandicapCasaTiposRankingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tipos_rankings', function (Blueprint $table) {
            $table->string('ds_badge');
            $table->boolean('id_handicap_casa');
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
            $table->dropColumn('ds_badge');
            $table->dropColumn('id_handicap_casa');
        });
    }
}
