<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameColumnInJournalCashBankDetailsAndJournalDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('journal_cash_bank_details', function (Blueprint $table) {
          $table->renameColumn('journal_id', 'journals_id');
        });
        Schema::table('journal_details', function (Blueprint $table) {
          $table->renameColumn('journal_id', 'journals_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('journal_cash_bank_details', function (Blueprint $table) {
            //
        });
    }
}
