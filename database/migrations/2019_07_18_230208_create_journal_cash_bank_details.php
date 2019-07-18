<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJournalCashBankDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('journal_cash_bank_details');
        Schema::dropIfExists('journal_detail_attributes');
        Schema::create('journal_cash_bank_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('journal_details_id');
            $table->bigInteger('unit_id')->nullable();
            $table->bigInteger('fund_requests_id')->nullable();
            $table->string('journal_detail_type')->nullable();
            $table->string('tax_type')->nullable();
            $table->double('tax_value',20,2)->nullable();
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
        Schema::dropIfExists('journal_cash_bank_details');
    }
}
