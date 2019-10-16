<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateBudgetDetailDraftRevisions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::dropIfExists('budget_draft_revisions');

      Schema::create('budget_detail_draft_revisions', function (Blueprint $table) {
          $table->bigInteger('budget_detail_drafts_id');
          $table->bigInteger('user_groups_id');
          $table->string('field', 255)->default('');
          $table->decimal('value', 20, 0)->default(0);
          $table->unique([
            'budget_detail_drafts_id',
            'user_groups_id'
          ], 'PrimaryRevision');

          $table->timestamps();
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::dropIfExists('budget_detail_draft_revisions');
    }
}
