<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPremiosTiposRankingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tipos_rankings', function (Blueprint $table) {
            $table->decimal('pc_premio1',5,2);
            $table->decimal('pc_premio2',5,2);
            $table->decimal('pc_premio3',5,2);
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
            $table->dropColumn('pc_premio1');
            $table->dropColumn('pc_premio2');
            $table->dropColumn('pc_premio3');
        });
    }
}
