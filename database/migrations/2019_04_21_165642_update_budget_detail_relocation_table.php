<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateBudgetDetailRelocationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('budget_relocation', function(Blueprint $table) {
          $table->dropColumn(['revised_amount', 'original_amount']);
          $table->decimal('source_original_amount',20,2)->default(0);
          $table->decimal('source_revised_amount',20,2)->default(0);
          $table->decimal('destination_original_amount',20,2)->default(0);
          $table->decimal('destination_revised_amount',20,2)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
