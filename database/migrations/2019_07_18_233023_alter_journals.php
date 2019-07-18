<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterJournals extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('journals', function (Blueprint $table) {
        $table->dropColumn('accepted_by');
        $table->dropColumn('submitted_by');
        $table->string('accepted_by', 255)->nullable();
        $table->string('submitted_by', 255)->nullable();
      });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('journals', function (Blueprint $table) {
          $table->dropColumn('accepted_by');
          $table->dropColumn('submitted_by');
        });
    }
}
