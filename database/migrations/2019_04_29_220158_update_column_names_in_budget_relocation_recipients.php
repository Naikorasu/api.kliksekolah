<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateColumnNamesInBudgetRelocationRecipients extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('budget_relocation_recipients', function (Blueprint $table) {
            $table->renameColumn('budget_detail_unique_id', 'budget_detail_id');
            $table->boolean('is_draft')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('budget_relocation_recipients', function (Blueprint $table) {
            //
        });
    }
}
