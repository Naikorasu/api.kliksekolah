<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUnitIdToTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('budgets', function (Blueprint $table) {
            $table->bigInteger('prm_school_units_id')->nullable();
        });

        Schema::table('budget_relocations', function (Blueprint $table) {
            $table->bigInteger('prm_school_units_id')->nullable();
        });

        Schema::table('budget_detail_drafts', function (Blueprint $table) {
            $table->bigInteger('prm_school_units_id')->nullable();
        });

        Schema::table('fund_requests', function (Blueprint $table) {
            $table->bigInteger('prm_school_units_id')->nullable();
        });

        Schema::table('journals', function (Blueprint $table) {
            $table->bigInteger('prm_school_units_id')->nullable();
        });

        Schema::table('non_budgets', function (Blueprint $table) {
            $table->bigInteger('prm_school_units_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tables', function (Blueprint $table) {
            //
        });
    }
}
