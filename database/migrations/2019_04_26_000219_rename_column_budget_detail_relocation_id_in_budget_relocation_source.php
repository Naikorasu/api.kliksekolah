<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameColumnBudgetDetailsRelocationIdInBudgetRelocationsSource extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('budget_relocation_sources', function (Blueprint $table) {
            $table->renameColumn('budget_detail_relocation_id','budget_relocation_id');
        });

        Schema::table('budget_relocation_recipients', function (Blueprint $table) {
            $table->renameColumn('budget_detail_relocation_id','budget_relocation_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('budget_relocation_sources', function (Blueprint $table) {
            //
        });
    }
}
