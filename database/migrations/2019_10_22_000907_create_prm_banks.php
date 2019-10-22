<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrmBanks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prm_banks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('account_number', 255)->unique();
            $table->string('bank_name', 255)->default('');
            $table->string('branch', 255)->default('');
            $table->string('account_owner', 255)->default('');
            $table->text('address');
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
        Schema::dropIfExists('prm_banks');
    }
}
