<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMsSiswa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ms_siswa', function (Blueprint $table) {
          $table->bigIncrements('id');
          $table->string('kode_va')->unique();
          $table->string('prm_school_units_id');
          $table->string('tahun');
          $table->string('nis');
          $table->string('nisn');
          $table->string('nama_siswa');
          $table->string('kelas');
          $table->string('paralel');
          $table->string('jurusan');
          $table->string('jenis_kelamin');
          $table->string('tempat_lahir');
          $table->date('tanggal_lahir')->nullable();
          $table->date('tanggal_diterima')->nullable();
          $table->string('pendidikan_sebelumnya');
          $table->string('alamat_siswa');
          $table->string('agama');
          $table->string('anak_ke');
          $table->string('jumlah_saudara');
          $table->string('tinggi_badan');
          $table->string('berat_badan');
          $table->string('golongan_darah');
          $table->string('nama_ayah_wali');
          $table->date('tanggal_lahir_ayah_wali');
          $table->string('pendidikan_ayah_wali');
          $table->string('pekerjaan_ayah_wali');
          $table->string('agama_ayah_wali');
          $table->string('nama_ibu_wali');
          $table->date('tanggal_lahir_ibu_wali');
          $table->string('pendidikan_ibu_wali');
          $table->string('pekerjaan_ibu_wali');
          $table->string('agama_ibu_wali');
          $table->string('no_telp_orang_tua');
          $table->text('alamat_orang_tua');
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
        Schema::dropIfExists('ms_siswa');
    }
}
