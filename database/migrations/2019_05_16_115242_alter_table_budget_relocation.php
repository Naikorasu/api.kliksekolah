<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableBudgetRelocation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('budget_relocation', function (Blueprint $table) {
            $table->renameColumn('head_unique_id','head');
            $table->renameColumn('account_unique_id', 'account');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('budget_relocation', function (Blueprint $table) {
            //
        });
    }
}
