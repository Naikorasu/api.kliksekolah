<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFundRequestDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fund_request_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('fund_request_id');
            $table->bigInteger('budget_detail_unique_id');
            $table->decimal('amount', 20,2);
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
        Schema::dropIfExists('fund_request_details');
    }
}
