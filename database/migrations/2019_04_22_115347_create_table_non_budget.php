<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableNonBudget extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('non_budget', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date');
            $table->string('activity',255)->default('');
            $table->text('description');
            $table->decimal('amount',20,2)->default(0);
            $table->string('code_of_account',255)->default('');
            $table->string('file_number',255)->default('');
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
        Schema::dropIfExists('non_budget');
    }
}
