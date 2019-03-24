<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSchoolUnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prm_school_units', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code_acc');
            $table->string('code_acb');
            $table->string('code_cab');
            $table->string('name');
            $table->text('address');
            $table->string('city');
            $table->string('phone_1');
            $table->string('phone_2');
            $table->string('tu_name');
            $table->string('ks_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prm_school_units');
    }
}
