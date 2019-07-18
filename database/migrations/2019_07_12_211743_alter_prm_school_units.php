<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterPrmSchoolUnits extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::dropIfExists('prm_school_units');
      Schema::create('prm_school_units', function (Blueprint $table) {
          $table->bigIncrements('id');
         $table->string('va_code')->unique();
         $table->string('unit_code')->unique();
         $table->string('name');
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
      Schema::dropIfExists('prm_school_units');
    }
}
