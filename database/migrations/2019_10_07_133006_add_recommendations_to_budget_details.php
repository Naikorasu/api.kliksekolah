<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRecommendationsToBudgetDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('budget_details', function (Blueprint $table) {
            $table->dropColumn('revision1', 'revision2');
            $table->decimal('recommendation_ypl', 20, 2)->nullable();
            $table->decimal('recommendation_committee', 20, 2)->nullable();
            $table->decimal('recommendation_bos', 20, 2)->nullable();
            $table->decimal('recommendation_intern', 20, 2)->nullable();
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
            $table->dropColumn(
              'recommendation_ypl',
              'recommendation_committee',
              'recommendation_bos',
              'recommendation_intern');
        });
    }
}
