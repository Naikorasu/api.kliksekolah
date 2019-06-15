<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateReferenceJournalDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('journal_cash_bank_details', function(Blueprint $table) {
          $table->bigInteger('journak_id')->default(0);
        });

        Schema::table('journal_details', function(Blueprint $table) {
          $table->renameColumn('cash_journal_id', 'journal_id');
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
