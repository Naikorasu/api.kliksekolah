<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnRevisionToBudgetDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('budget_details', function (Blueprint $table) {
            $table->decimal('revision1', 20, 0)->nullable();
            $table->decimal('revision2', 20, 0)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('budget_details', function (Blueprint $table) {
            $table->dropColumn('revision1', 'revision2');
        });
    }
}
