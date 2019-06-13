<?php

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
        Schema::create('cash_journals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date')->default('NOW()');
            $table->string('type')->default('');
            $table->string('receipt_number')->default('');
            $table->string('tax_number')->default('');
            $table->decimal('tax_value',20,0)->default(0.0);
            $table->string('submitted_by')->default('');
            $table->string('accepted_by')->default('');
            $table->decimal('gross_total',20,0)->default(0.0);
            $table->decimal('tax_deduction',20,0)->default(0.0);
            $table->decimal('nett_total',20,0)->default(0.0);
            $table->bigInteger('user_id');
            $table->timestamps();
        });

        Schema::create('cash_journal_details', function (Blueprint $table) {
          $table->bigIncrements('id');
          $table->bigInteger('cash_journal_id');
          $table->string('code')->default('');
          $table->text('description');
          $table->decimal('nominal', 20,0)->default(0.0);
          $table->bigInteger('uuser_id');
          $table->timestamps();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cash_journals');
        Schema::dropIfExists('cash_journal_details');
    }
}
