<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCodeAccountingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prm_code_class', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer("class");
            $table->text("title");
            $table->timestamps();
        });

        Schema::create('prm_code_category', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer("class");
            $table->integer("category");
            $table->text("title");
            $table->timestamps();
        });

        Schema::create('prm_code_group', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer("category");
            $table->integer("group");
            $table->text("title");
            $table->timestamps();
        });

        Schema::create('prm_code_account', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer("group");
            $table->integer("code");
            $table->text("title");
            $table->string("type");
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
        Schema::dropIfExists('code_accountings');
    }
}
