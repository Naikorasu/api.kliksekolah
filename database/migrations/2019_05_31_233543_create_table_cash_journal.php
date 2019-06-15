<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCashJournal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('journals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('journal_type')->default('KAS');
            $table->date('date')->default(Carbon::now());
            $table->string('journal_number',255)->default('');
            $table->bigInteger('user_id');
            $table->timestamps();
        });

        Schema::create('journal_cash_bank_details', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('reference_number');
            $table->string('counterparty',255)->default('');
            $table->string('tax_number',255)->default('');
            $table->decimal('tax_value', 20,0)->default(0);
            $table->decimal('gross_total', 20,0)->default(0);
            $table->decimal('tax_deduction', 20,0)->default(0);
            $table->decimal('nett_total', 20,0)->default(0);
            $table->timestamps();
        });

        Schema::create('journal_details', function (Blueprint $table) {
          $table->bigIncrements('id');
          $table->bigInteger('cash_journal_id');
          $table->bigInteger('code_of_account');
          $table->text('description');
          $table->decimal('debit', 20,0)->default(0);
          $table->decimal('credit', 20,0)->default(0);
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
        Schema::dropIfExists('journals');
        Schema::dropIfExists('journal_cash_bank_details');
        Schema::dropIfExists('journal_details');
    }
}
