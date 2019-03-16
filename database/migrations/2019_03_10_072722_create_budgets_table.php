<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBudgetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('budgets', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('unique_id');

            $table->integer('periode');
            $table->string('create_by');
            $table->text('desc');

            $table->timestamps();

        });

        Schema::create('budgets_account', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('unique_id');
            $table->string('head');

            $table->integer('account_type');
            $table->string('account_info');

            $table->timestamps();

        });


        Schema::create('budgets_detail', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('unique_id');
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
        Schema::dropIfExists('budgets');
        Schema::dropIfExists('budgets_account');
        Schema::dropIfExists('budgets_detail');
    }
}
