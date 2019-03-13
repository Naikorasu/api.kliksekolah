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
            $table->integer("code");
            $table->text("title");
            //$table->timestamps();
        });

        Schema::create('prm_code_category', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer("code");
            $table->integer("class");
            $table->text("title");
            //$table->timestamps();
        });

        Schema::create('prm_code_group', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer("code");
            $table->integer("category");
            $table->text("title");
            //$table->timestamps();
        });

        Schema::create('prm_code_account', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer("code");
            $table->integer("group");
            $table->text("title");
            $table->string("type");
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prm_code_class');
        Schema::dropIfExists('prm_code_category');
        Schema::dropIfExists('prm_code_group');
        Schema::dropIfExists('prm_code_account');
    }
}
