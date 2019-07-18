<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkflows extends Migration
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
            $table->string('entity_type');
            $table->bigInteger('entity_id');
            $table->string('next_role');
            $table->string('prev_role');
            $table->boolean('is_done')->default(false);
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
    }
}
