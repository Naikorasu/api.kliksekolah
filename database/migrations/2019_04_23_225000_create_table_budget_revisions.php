<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableBudgetRevisions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('budget_revisions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('budget_detail_unique_id',255)->default('');
            $table->text('original_values');
            $table->text('revised_values')->nullable();
            $table->bigInteger('user_id')->default(0);
            $table->timestamps();
        });

        Schema::table('budget_relocation', function(Blueprint $table) {
            $table->dropColumn(['source_original_amount', 'source_revised_amount', 'destination_revised_amount', 'destination_original_amount']);
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
        Schema::dropIfExists('budget_revisions');
    }
}
