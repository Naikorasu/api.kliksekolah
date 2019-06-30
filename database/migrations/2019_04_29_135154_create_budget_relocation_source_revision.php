<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBudgetRelocationSourceRevision extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('budget_relocation_revision', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('relocation_detail_id');
            $table->decimal('amount');
            $table->boolean('is_source')->default(false);
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
        Schema::dropIfExists('budget_relocation_source_revision');
    }
}
