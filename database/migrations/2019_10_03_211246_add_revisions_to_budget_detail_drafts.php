<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRevisionsToBudgetDetailDrafts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('budget_detail_drafts', function (Blueprint $table) {
          $table->decimal('revision1', 20, 0);
          $table->decimal('revision2', 20, 0);
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
            $table->dropColumn('revision1');
            $table->dropColumn('revision2');
        });
    }
}
