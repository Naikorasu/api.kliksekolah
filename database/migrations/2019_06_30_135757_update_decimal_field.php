<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateDecimalField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('budget_relocation_sources', function(Blueprint $table) {
        $table->decimal('relocated_amount',20,2)->default(0.0)->change();
      });
      Schema::table('budget_relocation_recipients', function(Blueprint $table) {
        $table->decimal('allocated_amount',20,2)->default(0.0)->change();
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
