<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterBudgetRevisions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::rename('budget_revisions', 'budget_draft_revisions');
      Schema::table('budget_draft_revisions', function(Blueprint $table) {
        $table->dropColumn(['budget_detail_unique_id','original_values','revised_values']);
        $table->bigInteger('budget_detail_draft_id');
        $table->decimal('revised_value', 20,5)->nullable();
        $table->string('field_name',255);
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('budget_draft_revisions');
    }
}
