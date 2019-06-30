<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableBudgetRelocation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('budget_relocation', function(Blueprint $table) {
        $table->bigIncrements('id');
        $table->string('source_unique_id', 255);
        $table->string('destination_unique_id', 255);
        $table->decimal('revised_amount')->default(0);
        $table->decimal('original_amount')->default(0);
        $table->bigInteger('user_id')->nullable();
        $table->boolean('is_approved')->default(false);
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
        Schema::dropIfExists('budget_relocation');
    }
}
