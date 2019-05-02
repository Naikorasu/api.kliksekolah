<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBudgetRelocationDetailTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('budget_relocation', function(Blueprint $table) {
            $table->dropColumn(['source_unique_id','destination_unique_id']);
        });

        Schema::create('budget_relocation_sources', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('budget_detail_relocation_id');
            $table->decimal('relocated_amount');
            $table->timestamps();
        });

        Schema::create('budget_relocation_recipients', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('budget_detail_relocation_id');
            $table->decimal('allocated_amount');
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
        Schema::dropIfExists('budget_relocation_sources');
        Schema::dropIfExists('budget_relocation_recipients');
    }
}
