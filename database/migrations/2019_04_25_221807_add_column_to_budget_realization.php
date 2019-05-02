<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToBudgetRealization extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('budget_realization', function (Blueprint $table) {
          $table->string('budget_detail_unique_id');
          $table->decimal('amount',20,2);
          $table->text('description');
          $table->string('filename',255);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('budget_realization', function (Blueprint $table) {
            //
        });
    }
}
