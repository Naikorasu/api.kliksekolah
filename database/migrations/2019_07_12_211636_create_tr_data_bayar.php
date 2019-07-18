<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrDataBayar extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tr_data_bayar', function (Blueprint $table) {
          $table->bigIncrements('id');
          $table->string('kode_va');
          $table->string('code');
          $table->boolean('is_routine')->default(false);
          $table->double('dp',20,0)->default(0);
          $table->double('nominal',20,2);
          $table->string('termin');
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
        Schema::dropIfExists('tr_data_bayar');
    }
}
