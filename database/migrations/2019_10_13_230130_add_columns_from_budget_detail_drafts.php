<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsFromBudgetDetailDrafts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('budget_detail_drafts', function (Blueprint $table) {
          $table->decimal('recommendation_ypl', 20, 0)->nullable();
          $table->decimal('recommendation_committee', 20, 0)->nullable();
          $table->decimal('recommendation_intern', 20, 0)->nullable();
          $table->decimal('recommendation_bos', 20, 0)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('budget_detail_drafts', function (Blueprint $table) {
            $table->dropColumn('recommendation_ypl', 'recommendation_committee', 'recommendation_intern', 'recommendation_bos');
        });
    }
}
