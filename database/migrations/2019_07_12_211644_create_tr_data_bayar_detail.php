<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrDataBayarDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tr_data_bayar_detail', function (Blueprint $table) {
          $table->bigIncrements('id');
          $table->string('kode_va');
          $table->string('kode_pembayaran')->comment('SPP, UPP, DPP, kegiatan');
          $table->string('mmyy')->comment('Routine -> MMYY, not routine -> 5 digit pertama coa, 3 digit termin');
          $table->double('nominal',20,2);
          $table->date('tanggal_bayar')->nullable();
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
        Schema::dropIfExists('tr_data_bayar_detail');
    }
}
