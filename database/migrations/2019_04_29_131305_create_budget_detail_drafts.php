<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBudgetDetailDrafts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('budget_detail_drafts', function (Blueprint $table) {
          $table->bigIncrements('id');

          $table->string('head');
          $table->string('account');
          $table->integer('semester');

          $table->integer('code_of_account');
          $table->string('title');

          $table->decimal('quantity',18,0);
          $table->decimal('price',18,0);
          $table->decimal('term',18,0);

          $table->decimal('ypl',18,0);
          $table->decimal('committee',18,0);
          $table->decimal('intern',18,0);
          $table->decimal('bos',18,0);

          $table->decimal('total',18,0);
          $table->text('desc');

          $table->bigInteger('user_id');
          $table->boolean('submitted')->default(false);
          $table->boolean('approved')->default(false);

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
        Schema::dropIfExists('budget_detail_drafts');
    }
}
