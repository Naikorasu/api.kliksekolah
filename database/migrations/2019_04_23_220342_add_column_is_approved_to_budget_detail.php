<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnIsApprovedToBudgetDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('budgets_detail', function (Blueprint $table) {
            $table->boolean('is_approved')->default(false);
            $table->boolean('submitted')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('budgets_detail', function (Blueprint $table) {
            $table->dropColumn(['is_approved', 'submitted']);
        });
    }
}
