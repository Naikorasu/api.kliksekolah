<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkflowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workflows', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('workflow_id');
            $table->string('transaction_key');
            $table->string('workflow_mod');
            $table->timestamps();
        });

        Schema::create('workflows_detail', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('workflow');
            $table->string('user');
            $table->string('flow');
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
        Schema::dropIfExists('workflows');
        Schema::dropIfExists('workflows_detail');
    }
}
