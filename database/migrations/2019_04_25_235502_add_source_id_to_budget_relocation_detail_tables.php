<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSourceIdToBudgetRelocationsDetailTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('budget_relocation_sources', function (Blueprint $table) {
            $table->string('budget_detail_unique_id',255);
        });

        Schema::table('budget_relocation_recipients', function (Blueprint $table) {
            $table->string('budget_detail_unique_id',255);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('budget_relocation_detail_tables', function (Blueprint $table) {
            $table->dropColumn('budget_detail_unique_id');
        });

        Schema::table('budget_relocation_recipients', function (Blueprint $table) {
            $table->dropColumn('budget_detail_unique_id');
        });
    }
}
