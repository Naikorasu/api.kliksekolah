<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUniqueKeyToBudgetDetailDraftRevisions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('budget_detail_draft_revisions', function (Blueprint $table) {
            $table->string('field', 50)->default('')->change();
            $table->unique([
              'field',
              'budget_detail_drafts_id',
              'user_groups_id'
            ], 'RevisionsIndex');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('budget_detail_draft_revisions', function (Blueprint $table) {
            //
        });
    }
}
