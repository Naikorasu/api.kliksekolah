<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddHeadAndAccountToBudgetRelocation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('budget_relocation', function (Blueprint $table) {
            $table->string('head_unique_id')->default('');
            $table->string('account_unique_id')->default('');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('budget_relocation', function (Blueprint $table) {
            //
        });
    }
}
