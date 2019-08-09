<?php

use Illuminate\Database\Seeder;

class ParameterTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //


        //SCHOOL UNITS

        /*
        DB::table('prm_school_units')->insert([
            'code' => "A01",
            'name' => "YPL PERWAKILAN AMBARAWA",
            'address' => "",
        ]);
        */


        //CODE CLASS

        DB::table('prm_code_class')->insert([
            'code' => "10000",
            'title' => "AKTIVA",
        ]);

        DB::table('prm_code_class')->insert([
            'code' => "20000",
            'title' => "PASIVA",
        ]);

        DB::table('prm_code_class')->insert([
            'code' => "30000",
            'title' => "EKUITAS",
        ]);

        DB::table('prm_code_class')->insert([
            'code' => "40000",
            'title' => "PENDAPATAN",
        ]);

        DB::table('prm_code_class')->insert([
            'code' => "50000",
            'title' => "BEBAN",
        ]);


        //CODE CATEGORY

        DB::table('prm_code_category')->insert([
            'class' => "10000",
            'code' => "11000",
            'title' => "AKTIVA LANCAR",
        ]);

        DB::table('prm_code_category')->insert([
            'class' => "10000",
            'code' => "12000",
            'title' => "AKTIVA TIDAK LANCAR",
        ]);

        DB::table('prm_code_category')->insert([
            'class' => "10000",
            'code' => "13000",
            'title' => "AKTIVA TETAP",
        ]);

        DB::table('prm_code_category')->insert([
            'class' => "20000",
            'code' => "21000",
            'title' => "KEWAJIBAN",
        ]);

        DB::table('prm_code_category')->insert([
            'class' => "30000",
            'code' => "31000",
            'title' => "ASSET BERSIH",
        ]);

        DB::table('prm_code_category')->insert([
            'class' => "40000",
            'code' => "41000",
            'title' => "PENDAPATAN TERIKAT PERMANEN",
        ]);

        DB::table('prm_code_category')->insert([
            'class' => "40000",
            'code' => "42000",
            'title' => "PENDAPATAN TERIKAT TEMPORER",
        ]);

        DB::table('prm_code_category')->insert([
            'class' => "50000",
            'code' => "51000",
            'title' => "BELANJA JASA PEGAWAI",
        ]);

        DB::table('prm_code_category')->insert([
            'class' => "50000",
            'code' => "52000",
            'title' => "BEBAN PROGRAM PENDIDIKAN NASIONAL",
        ]);

        DB::table('prm_code_category')->insert([
            'class' => "50000",
            'code' => "53000",
            'title' => "BEBAN OPERASIONAL YAYASAN",
        ]);

        DB::table('prm_code_category')->insert([
            'class' => "50000",
            'code' => "54000",
            'title' => "BIAYA ADMINISTRASI UMUM",
        ]);



        //CODE GROUP

        DB::table('prm_code_group')->insert([
            'category' => "11000",
            'code' => "11100",
            'title' => "KAS",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "11000",
            'code' => "11200",
            'title' => "TABUNGAN",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "11000",
            'code' => "11300",
            'title' => "GIRO",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "11000",
            'code' => "11400",
            'title' => "DEPOSITO",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "11000",
            'code' => "11500",
            'title' => "PERSEDIAAN",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "11000",
            'code' => "11600",
            'title' => "PERLENGKAPAN",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "12000",
            'code' => "12100",
            'title' => "INVESTASI",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "12000",
            'code' => "12200",
            'title' => "PIUTANG TERIKAT PERMANEN",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "12000",
            'code' => "12300",
            'title' => "PIUTANG TERIKAT TEMPORER",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "12000",
            'code' => "12400",
            'title' => "PIUTANG UNIT",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "12000",
            'code' => "12500",
            'title' => "PIUTANG PEGAWAI",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "12000",
            'code' => "12600",
            'title' => "PIUTANG LAIN",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "12000",
            'code' => "12700",
            'title' => "CADANGAN KERUGIAN PIUTANG PERMANEN",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "12000",
            'code' => "12800",
            'title' => "CADANGAN KERUGIAN PIUTANG TEMPORER",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "12000",
            'code' => "12900",
            'title' => "BIAYA DIBAYAR DIMUKA",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "12000",
            'code' => "12910",
            'title' => "AKTIVA TETAP TIDAK BERWUJUD",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "12000",
            'code' => "12920",
            'title' => "REKENING KORAN KANTOR",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "13000",
            'code' => "13100",
            'title' => "DANA BANGUNAN / PRASARANA YANG DIGUNAKAN",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "13000",
            'code' => "13200",
            'title' => "TANAH",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "13000",
            'code' => "13300",
            'title' => "BANGUNAN",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "13000",
            'code' => "13400",
            'title' => "INVENTARIS KELOMPOK I",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "13000",
            'code' => "13500",
            'title' => "INVENTARIS KELOMPOK II",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "13000",
            'code' => "13600",
            'title' => "AKUMULASI PENYUSUTAN DAPEM",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "13000",
            'code' => "13700",
            'title' => "AKUMULASI PENYUSUTAN BANGUNAN",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "13000",
            'code' => "13800",
            'title' => "AKUMULASI PENYUSUTAN KELOMPOK I",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "13000",
            'code' => "13900",
            'title' => "AKUMULASI PENYUSUTAN KELOMPOK II",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "13000",
            'code' => "13900",
            'title' => "AKUMULASI PENYUSUTAN KELOMPOK II",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "21000",
            'code' => "21100",
            'title' => "HUTANG PAJAK",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "21000",
            'code' => "21200",
            'title' => "HUTANG LAIN",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "21000",
            'code' => "21300",
            'title' => "JAMINAN KESEJAHTERAAN KARYAWAN",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "21000",
            'code' => "21400",
            'title' => "DANA ASOM",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "21000",
            'code' => "21500",
            'title' => "BIAYA YANG MASIH HARUS DIBAYAR",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "21000",
            'code' => "21600",
            'title' => "DANA BANGUNAN / PRASARANA YANG BLM DIGUNAKAN",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "21000",
            'code' => "21700",
            'title' => "PENDAPATAN DITERIMA DIMUKA PERMANEN",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "21000",
            'code' => "21800",
            'title' => "PENDAPATAN DITERIMA DIMUKA TEMPORER",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "31000",
            'code' => "31100",
            'title' => "ASSET BERSIH TIDAK TERIKAT",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "31000",
            'code' => "31200",
            'title' => "ASSET BERSIH TERIKAT",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "41000",
            'code' => "41100",
            'title' => "DANA PENGEMBANGAN PENDIDIKAN",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "41000",
            'code' => "41200",
            'title' => "UANG PERSIAPAN PENDIDIKAN",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "41000",
            'code' => "41300",
            'title' => "UANG SEKOLAH",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "41000",
            'code' => "41400",
            'title' => "UANG KOMPUTER",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "41000",
            'code' => "41500",
            'title' => "UANG KEGIATAN SISWA",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "41000",
            'code' => "41600",
            'title' => "UANG SARANA PRASARANA PENDIDIKAN",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "41000",
            'code' => "41700",
            'title' => "DANA ASRAMA",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "41000",
            'code' => "41800",
            'title' => "PENDAPATAN KOMITE SEKOLAH",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "42000",
            'code' => "42100",
            'title' => "PENDAPATAN PPDB",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "42000",
            'code' => "42200",
            'title' => "PENDAPATAN FASILATAS",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "42000",
            'code' => "42300",
            'title' => "PENDAPATAN PENJUALAN",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "42000",
            'code' => "42400",
            'title' => "PENERIMAAN RETRET",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "42000",
            'code' => "42500",
            'title' => "PENDAPATAN PEMANFAATAN ASSET",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "42000",
            'code' => "42600",
            'title' => "PENDAPATAN SUMBANGAN",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "42000",
            'code' => "42700",
            'title' => "PENDAPATAN BUNGA INVESTASI",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "42000",
            'code' => "42800",
            'title' => "PENDAPATAN LAIN-LAIN",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "51000",
            'code' => "51100",
            'title' => "PENGGAJIAN PEGAWAI TETAP",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "51000",
            'code' => "51200",
            'title' => "HONOR TIDAK RUTIN",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "51000",
            'code' => "51300",
            'title' => "PENGGAJIAN PEGAWAI TIDAK TETAP",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "51000",
            'code' => "51400",
            'title' => "PENGGAJIAN GURU EKSTRAKURIKULER",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "51000",
            'code' => "51500",
            'title' => "UPAH TUKANG",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "51000",
            'code' => "51600",
            'title' => "BIAYA JASA",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "51000",
            'code' => "51700",
            'title' => "BIAYA JASA KONSTRUKSI",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "52000",
            'code' => "52100",
            'title' => "PENGEMBANGAN KOMPETENSI KELULUSAN",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "52000",
            'code' => "52200",
            'title' => "PENGEMBANGAN STANDART ISI",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "52000",
            'code' => "52300",
            'title' => "PENGEMBANGAN STANDART PROSES",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "52000",
            'code' => "52400",
            'title' => "PENGEMBANGAN PENDIDIK DAN TENAGA KEPENDIDIKAN",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "52000",
            'code' => "52500",
            'title' => "PENGEMBANGAN SARANA DAN PRASARANA",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "52000",
            'code' => "52600",
            'title' => "PENGEMBANGAN IMPLEMENTASI MANAJEMEN",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "52000",
            'code' => "52700",
            'title' => "PENGEMBANGAN PENGGALIAN SUMBER DANA PENDIDIKAN",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "52000",
            'code' => "52800",
            'title' => "PENGEMBANGAN DAN IMPLEMENTASI SISTEM PENILAIAN",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "53000",
            'code' => "53100",
            'title' => "BEBAN YAYASAN",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "53000",
            'code' => "53200",
            'title' => "BEBAN KANTOR",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "53000",
            'code' => "53300",
            'title' => "BEBAN PENDIDIKAN DAN ASRAMA",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "53000",
            'code' => "53400",
            'title' => "KEGIATAN SEKOLAH",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "53000",
            'code' => "53500",
            'title' => "BEBAN LAYANAN DAYA DAN JASA",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "53000",
            'code' => "53600",
            'title' => "BEBAN PAJAK",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "53000",
            'code' => "53700",
            'title' => "PIUTANG TAK TERTAGIH PERMANENT",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "53000",
            'code' => "53800",
            'title' => "PIUTANG TAK TERTAGIH TEMPORER",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "53000",
            'code' => "53900",
            'title' => "BEBAN KERUGIAN ASSET",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "53000",
            'code' => "53910",
            'title' => "BIAYA PENYUSUTAN",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "54000",
            'code' => "54100",
            'title' => "BIAYA ADMINISTRASI",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "54000",
            'code' => "54200",
            'title' => "BIAYA SUMBANGAN SOSIAL",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "54000",
            'code' => "54300",
            'title' => "BIAYA INVESTASI",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "54000",
            'code' => "54500",
            'title' => "BIAYA PAMBALANCE",
        ]);



        //CODE ACCOUNT

        DB::table('prm_code_account')->insert([
            'group' => "11100",
            'code' => "11101",
            'title' => "Kas Tunai",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "11200",
            'code' => "11201",
            'title' => "Rekening Tabungan BCA",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "11200",
            'code' => "11202",
            'title' => "Rekening Tabungan BNI",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "11200",
            'code' => "11203",
            'title' => "Rekening Tabungan BPD",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "11200",
            'code' => "11204",
            'title' => "Rekening Tabungan BPR",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "11200",
            'code' => "11205",
            'title' => "Rekening Tabungan BRI",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "11200",
            'code' => "11206",
            'title' => "Rekening Tabungan BTN",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "11200",
            'code' => "11207",
            'title' => "Rekening Tabungan BANK CIMB NIAGA",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "11200",
            'code' => "11208",
            'title' => "Rekening Tabungan CU",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "11200",
            'code' => "11209",
            'title' => "Rekening Tabungan BANK DANAMON",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "11200",
            'code' => "11210",
            'title' => "Rekening Tabungan BANK MANDIRI",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "11200",
            'code' => "11211",
            'title' => "Rekening Tabungan BANK MAYAPADA",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "11200",
            'code' => "11212",
            'title' => "Rekening Tabungan BANK OCBC NISP",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "11200",
            'code' => "11213",
            'title' => "Rekening Tabungan Titipan Obat",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "11200",
            'code' => "11214",
            'title' => "Rekening Tabungan BANK UOB",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "11300",
            'code' => "11301",
            'title' => "Rekening Giro BCA",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "11300",
            'code' => "11302",
            'title' => "Rekening Giro BNI",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "11300",
            'code' => "11303",
            'title' => "Rekening Giro BPD",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "11300",
            'code' => "11304",
            'title' => "Rekening Giro BPR",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "11300",
            'code' => "11305",
            'title' => "Rekening Giro BRI",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "11300",
            'code' => "11306",
            'title' => "Rekening Giro BTN",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "11300",
            'code' => "11307",
            'title' => "Rekening Giro BANK CIMB NIAGA",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "11300",
            'code' => "11308",
            'title' => "Rekening Giro CU",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "11300",
            'code' => "11309",
            'title' => "Rekening Giro BANK DANAMON",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "11300",
            'code' => "11310",
            'title' => "Rekening Giro BANK MANDIRI",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "11300",
            'code' => "11311",
            'title' => "Rekening Giro BANK MAYAPADA",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "11300",
            'code' => "11312",
            'title' => "Rekening Giro BANK OCBC NISP",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "11300",
            'code' => "11313",
            'title' => "Rekening Giro BANK UOB",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "11400",
            'code' => "11401",
            'title' => "Rekening Deposito BCA",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "11400",
            'code' => "11402",
            'title' => "Rekening Deposito BNI",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "11400",
            'code' => "11403",
            'title' => "Rekening Deposito BPD",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "11400",
            'code' => "11404",
            'title' => "Rekening Deposito BPR",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "11400",
            'code' => "11405",
            'title' => "Rekening Deposito BRI",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "11400",
            'code' => "11406",
            'title' => "Rekening Deposito BTN",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "11400",
            'code' => "11407",
            'title' => "Rekening Deposito BANK CIMB NIAGA",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "11400",
            'code' => "11408",
            'title' => "Rekening Deposito CU",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "11400",
            'code' => "11409",
            'title' => "Rekening Deposito BANK DANAMON",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "11400",
            'code' => "11410",
            'title' => "Rekening Deposito BANK MAYAPADA",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "11400",
            'code' => "11411",
            'title' => "Rekening Deposito BANK MAYAPADA",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "11400",
            'code' => "11412",
            'title' => "Rekening Deposito BANK OCBC NISP",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "11400",
            'code' => "11413",
            'title' => "Rekening Deposito BANK UOB",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "11500",
            'code' => "11501",
            'title' => "Persediaan ATK",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "11500",
            'code' => "11502",
            'title' => "Persediaan Buku",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "11500",
            'code' => "11503",
            'title' => "Persediaan Seragam",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "11500",
            'code' => "11504",
            'title' => "Persediaan Lainnya",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "11600",
            'code' => "11601",
            'title' => "Perlengkapan Kantor",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "11600",
            'code' => "11602",
            'title' => "Perlengkapan Laboratorium",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "11600",
            'code' => "11603",
            'title' => "Perlengkapan Lainnya",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "12100",
            'code' => "12101",
            'title' => "Saham",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "12100",
            'code' => "12102",
            'title' => "Obligasi",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "12100",
            'code' => "12103",
            'title' => "Reksa Dana",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "12100",
            'code' => "12104",
            'title' => "Investasi Lainnya",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "12200",
            'code' => "12201",
            'title' => "Piutang DPP",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "12200",
            'code' => "12202",
            'title' => "Piutang UPP",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "12200",
            'code' => "12203",
            'title' => "Piutang Uang Sekolah",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "12200",
            'code' => "12204",
            'title' => "Piutang Uang Komputer",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "12200",
            'code' => "12205",
            'title' => "Piutang Uang Kegiatan",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "12200",
            'code' => "12206",
            'title' => "Piutang Uang Sarana dan Prasarana Pendidikan",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "12200",
            'code' => "12207",
            'title' => "Piutang Uang Asrama",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "12200",
            'code' => "12208",
            'title' => "Piutang Uang Komite",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "12300",
            'code' => "12301",
            'title' => "Piutang Pelangi Kasih",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "12300",
            'code' => "12302",
            'title' => "Piutang Antar Jemput",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "12300",
            'code' => "12303",
            'title' => "Piutang Seragam Siswa",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "12300",
            'code' => "12304",
            'title' => "Piutang Buku",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "12300",
            'code' => "12305",
            'title' => "Piutang Peralatan Sekolah",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "12300",
            'code' => "12306",
            'title' => "Piutang Kantin",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "12300",
            'code' => "12307",
            'title' => "Piutang UKB",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "12400",
            'code' => "12401",
            'title' => "Piutang Seragam YPL",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "12400",
            'code' => "12402",
            'title' => "Piutang Dana Talangan",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "12500",
            'code' => "12501",
            'title' => "Piutang Study",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "12500",
            'code' => "12502",
            'title' => "Piutang Kesehatan (RS)",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "12500",
            'code' => "12503",
            'title' => "Piutang Tebusan Masa Kerja",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "12500",
            'code' => "12504",
            'title' => "Piutang Kasus",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "12600",
            'code' => "12601",
            'title' => "Piutang DP",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "12600",
            'code' => "12602",
            'title' => "Piutang Pihak ke-3",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "12700",
            'code' => "12701",
            'title' => "Biaya Dibayar Dimuka",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "12800",
            'code' => "12801",
            'title' => "Asset Tetap Tidak Berwujud",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "12900",
            'code' => "12901",
            'title' => "Rekonsiliasi Unit Pangudi Luhur",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "12900",
            'code' => "12902",
            'title' => "Rekonsiliasi H2H",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "13100",
            'code' => "13101",
            'title' => "Dana Pembangunan dan Sarana Pendidikan",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "13200",
            'code' => "13201",
            'title' => "Tanah",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "13300",
            'code' => "13301",
            'title' => "Bangunan",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "13400",
            'code' => "13401",
            'title' => "Peralatan Sekolah ( Meja, Kursi, Lemari, dll. )",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "13400",
            'code' => "13402",
            'title' => "Peralatan Elektronik ( Komputer, Printer, Mesin FC, Scaner, Kamera, dll )",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "13400",
            'code' => "13403",
            'title' => "Peralatan lain ( Alat Musik, Alat Olahraga, Alat Laboratorium, dll )",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "13400",
            'code' => "13404",
            'title' => "Sepeda, dan Kendaraan Bermotor",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "13500",
            'code' => "13501",
            'title' => "Inventaris dari Besi ( Brankas, dll. )",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "13500",
            'code' => "13502",
            'title' => "Kendaraan Roda Empat",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "13500",
            'code' => "13503",
            'title' => "Mesin Ringan",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "13600",
            'code' => "13601",
            'title' => "Akumulasi Penyusutan Dapem",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "13700",
            'code' => "13701",
            'title' => "Akumulasi Penyusutan Bangunan",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "13800",
            'code' => "13801",
            'title' => "Akumulasi Penyusutan Kelompok I",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "13900",
            'code' => "13901",
            'title' => "Akumulasi Penyusutan Kelompok II",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "21100",
            'code' => "21101",
            'title' => "PPh 21",
            'type' => 'K',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "21100",
            'code' => "21102",
            'title' => "PPh Ps 4,ayat 2 Pengawas konstruksi(4%)",
            'type' => 'K',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "21100",
            'code' => "21103",
            'title' => "PPh Ps 4,ayat 2 Pelaksana konstruksi(2%)",
            'type' => 'K',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "21100",
            'code' => "21104",
            'title' => "PPh Ps 4,ayat 2 Perencanaan konstruksi(4%)",
            'type' => 'K',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "21100",
            'code' => "21105",
            'title' => "PPh ps 4, ayat 2 menyewa ruang",
            'type' => 'K',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "21100",
            'code' => "21106",
            'title' => "PPh 23 Jasa",
            'type' => 'K',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "21100",
            'code' => "21107",
            'title' => "PPh 25",
            'type' => 'K',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "21200",
            'code' => "21201",
            'title' => "Hutang Pegawai (Gaji PNS)",
            'type' => 'K',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "21200",
            'code' => "21202",
            'title' => "Hutang Pihak-3 (Lainnya)",
            'type' => 'K',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "21200",
            'code' => "21203",
            'title' => "Titipan Sekolah (Audit)",
            'type' => 'K',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "21200",
            'code' => "21204",
            'title' => "Hutang Yayasan",
            'type' => 'K',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "21200",
            'code' => "21205",
            'title' => "Titipan CU",
            'type' => 'K',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "21200",
            'code' => "21206",
            'title' => "Titipan Sekolah Intern",
            'type' => 'K',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "21300",
            'code' => "21301",
            'title' => "Dana Kesehatan",
            'type' => 'K',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "21300",
            'code' => "21302",
            'title' => "Dana BPJS Kesehatan",
            'type' => 'K',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "21300",
            'code' => "21303",
            'title' => "Dana Yadapen",
            'type' => 'K',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "21300",
            'code' => "21304",
            'title' => "Dana Purna Bakti Pegawai",
            'type' => 'K',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "21300",
            'code' => "21305",
            'title' => "Dana Sosial Kanisius ( IDS )",
            'type' => 'K',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "21300",
            'code' => "21306",
            'title' => "Dana Sosial Kematian",
            'type' => 'K',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "21300",
            'code' => "21307",
            'title' => "Dana BPJS Jaminan Pensiun (JP)",
            'type' => 'K',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "21300",
            'code' => "21308",
            'title' => "Dana BPJS Jaminan Kecelakaan Kerja (JKK)",
            'type' => 'K',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "21300",
            'code' => "21309",
            'title' => "Dana BPJS Jaminan Kematian (JKM)",
            'type' => 'K',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "21300",
            'code' => "21310",
            'title' => "Dana BPJS Jaminan Hari Tua (JHT)",
            'type' => 'K',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "21300",
            'code' => "21311",
            'title' => "Dana Cadangan Purna Bakti Pegawai",
            'type' => 'K',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "21400",
            'code' => "21401",
            'title' => "Dana Sosial Orang Miskin",
            'type' => 'K',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "21400",
            'code' => "21402",
            'title' => "Dana Beasiswa",
            'type' => 'K',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "21400",
            'code' => "21403",
            'title' => "Dana Peningkatan Mutu Pendidikan",
            'type' => 'K',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "21400",
            'code' => "21404",
            'title' => "Dana Cadangan Kerugian Piutang",
            'type' => 'K',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "21500",
            'code' => "21501",
            'title' => "YMHD Telepon",
            'type' => 'K',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "21500",
            'code' => "21502",
            'title' => "YMHD Listrik",
            'type' => 'K',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "21500",
            'code' => "21503",
            'title' => "YMHD PAM",
            'type' => 'K',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "21500",
            'code' => "21504",
            'title' => "YMHD BPJS",
            'type' => 'K',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "21500",
            'code' => "21505",
            'title' => "YMHD Yadapen",
            'type' => 'K',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "21500",
            'code' => "21506",
            'title' => "YMHD Titipan Asrama",
            'type' => 'K',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "21500",
            'code' => "21507",
            'title' => "YMHD Komite",
            'type' => 'K',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "21500",
            'code' => "21508",
            'title' => "YMHD Kantin",
            'type' => 'K',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "21500",
            'code' => "21509",
            'title' => "YMHD Seragam",
            'type' => 'K',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "21500",
            'code' => "21510",
            'title' => "YMHD Buku",
            'type' => 'K',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "21500",
            'code' => "21511",
            'title' => "YMHD Sosial",
            'type' => 'K',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "21600",
            'code' => "21601",
            'title' => "Dana Bangunan / Prasarana Yang belum digunakan",
            'type' => 'K',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "21700",
            'code' => "21701",
            'title' => "Pendapatan Diterima Dimuka DPP",
            'type' => 'K',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "21700",
            'code' => "21702",
            'title' => "Pendapatan Diterima Dimuka UPP",
            'type' => 'K',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "21700",
            'code' => "21703",
            'title' => "Pendapatan Diterima Dimuka Uang Sekolah",
            'type' => 'K',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "21700",
            'code' => "21704",
            'title' => "Pendapatan Diterima Dimuka Uang Komputer",
            'type' => 'K',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "21700",
            'code' => "21705",
            'title' => "Pendapatan Diterima Dimuka Uang Kegiatan",
            'type' => 'K',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "21700",
            'code' => "21706",
            'title' => "Pendapatan Diterima Dimuka Uang Sarana Prasarana Pendidikan",
            'type' => 'K',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "21700",
            'code' => "21707",
            'title' => "Pendapatan Diterima Dimuka Uang Asrama",
            'type' => 'K',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "21700",
            'code' => "21708",
            'title' => "Pendapatan Diterima Dimuka Uang Komite",
            'type' => 'K',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "21800",
            'code' => "21801",
            'title' => "Pendapatan Diterima Dimuka Pelangi Kasih",
            'type' => 'K',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "21800",
            'code' => "21802",
            'title' => "Pendapatan Diterima Dimuka Antar Jemput",
            'type' => 'K',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "21800",
            'code' => "21803",
            'title' => "Pendapatan Diterima Dimuka Seragam Siswa",
            'type' => 'K',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "21800",
            'code' => "21804",
            'title' => "Pendapatan Diterima Dimuka Buku",
            'type' => 'K',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "21800",
            'code' => "21805",
            'title' => "Pendapatan Diterima Dimuka Peralatan Sekolah",
            'type' => 'K',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "21800",
            'code' => "21806",
            'title' => "Pendapatan Diterima Dimuka Kantin",
            'type' => 'K',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "21800",
            'code' => "21807",
            'title' => "Pendapatan Diterima Dimuka UKB",
            'type' => 'K',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "31100",
            'code' => "31101",
            'title' => "Aset Bersih Tidak Terikat",
            'type' => 'K',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "31200",
            'code' => "31201",
            'title' => "Asset Bersih Terikat",
            'type' => 'K',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "31200",
            'code' => "31201",
            'title' => "Asset Bersih Terikat",
            'type' => 'K',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "41100",
            'code' => "41101",
            'title' => "Dana Pengembangan Pendidikan",
            'type' => 'K',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "41200",
            'code' => "41201",
            'title' => "Uang Persiapan Pendidikan",
            'type' => 'K',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "41300",
            'code' => "41301",
            'title' => "Uang Sekolah",
            'type' => 'K',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "41400",
            'code' => "41401",
            'title' => "Uang Komputer",
            'type' => 'K',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "41500",
            'code' => "41501",
            'title' => "Uang Kegiatan Siswa",
            'type' => 'K',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "41600",
            'code' => "41601",
            'title' => "Uang Sarana Prasarana Pendidikan",
            'type' => 'K',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "41700",
            'code' => "41701",
            'title' => "Uang Pangkal Asrama",
            'type' => 'K',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "41700",
            'code' => "41702",
            'title' => "Uang Bulanan Asrama",
            'type' => 'K',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "41800",
            'code' => "41801",
            'title' => "Pendapatan Komite",
            'type' => 'K',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "42100",
            'code' => "42101",
            'title' => "Formulir Pendaftaran",
            'type' => 'K',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "42100",
            'code' => "42102",
            'title' => "Seragam YPL",
            'type' => 'K',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "42100",
            'code' => "42103",
            'title' => "Buku YPL",
            'type' => 'K',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "42200",
            'code' => "42201",
            'title' => "Pendapatan Pelangi Kasih",
            'type' => 'K',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "42200",
            'code' => "42202",
            'title' => "Pendapatan Antar Jemput",
            'type' => 'K',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "42300",
            'code' => "42301",
            'title' => "Penjualan Seragam",
            'type' => 'K',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "42300",
            'code' => "42302",
            'title' => "Penjualan Buku",
            'type' => 'K',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "42300",
            'code' => "42303",
            'title' => "Penjualan Peralatan Sekolah",
            'type' => 'K',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "42400",
            'code' => "42401",
            'title' => "Penerimaan Retret",
            'type' => 'K',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "42500",
            'code' => "42501",
            'title' => "Pendapatan Pemanfaatan Asset",
            'type' => 'K',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "42500",
            'code' => "42502",
            'title' => "Pendapatan Penjualan Asset",
            'type' => 'K',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "42500",
            'code' => "42503",
            'title' => "Pendapatan Hasil Kebun",
            'type' => 'K',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "42600",
            'code' => "42601",
            'title' => "Bantuan Pemerintah",
            'type' => 'K',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "42600",
            'code' => "42602",
            'title' => "Bantuan Alumnus/Wali Peserta Didik",
            'type' => 'K',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "42600",
            'code' => "42603",
            'title' => "Bantuan Pihak Lain",
            'type' => 'K',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "42700",
            'code' => "42701",
            'title' => "Bunga Bank",
            'type' => 'K',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "42700",
            'code' => "42702",
            'title' => "Hasil Surat Berharga",
            'type' => 'K',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "42700",
            'code' => "42703",
            'title' => "Laba Selisih Kurs",
            'type' => 'K',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "42700",
            'code' => "42704",
            'title' => "Diskon",
            'type' => 'K',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "42800",
            'code' => "42801",
            'title' => "Kantin",
            'type' => 'K',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "42800",
            'code' => "42802",
            'title' => "UKB",
            'type' => 'K',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "51100",
            'code' => "51101",
            'title' => "Gaji Pegawai tetap",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "51100",
            'code' => "51102",
            'title' => "Subsidi BPJS Kesehatan",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "51100",
            'code' => "51103",
            'title' => "Subsidi BPJS Jaminan Pensiun (JP)",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "51100",
            'code' => "51104",
            'title' => "Subsidi BPJS Jaminan Kecelakaan Kerja (JKK)",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "51100",
            'code' => "51105",
            'title' => "Subsidi BPJS Jaminan Kematian (JKM)",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "51100",
            'code' => "51106",
            'title' => "Subsidi BPJS Jaminan Hari Tua (JHT)",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "51100",
            'code' => "51107",
            'title' => "Subsidi Yadapen",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "51100",
            'code' => "51108",
            'title' => "Tunjangan Beras",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "51100",
            'code' => "51109",
            'title' => "Tunjangan Istri/Suami",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "51100",
            'code' => "51110",
            'title' => "Tunjangan Anak",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "51100",
            'code' => "51111",
            'title' => "Tunjangan Kepala Sekolah",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "51100",
            'code' => "51112",
            'title' => "Tunjangan Wakil Kepala Sekolah",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "51100",
            'code' => "51113",
            'title' => "Tunjangan Koordinator/Pembina Kegiatan Kesiswaan/Kajur",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "51100",
            'code' => "51114",
            'title' => "Tunjangan Staff/Tim",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "51100",
            'code' => "51115",
            'title' => "Tunjangan Wali Kelas",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "51100",
            'code' => "51116",
            'title' => "Tunjangan Kepala TU",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "51100",
            'code' => "51117",
            'title' => "Tunjangan Korektor Sekolah",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "51100",
            'code' => "51118",
            'title' => "Tunjangan Rektor",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "51100",
            'code' => "51119",
            'title' => "Tunjangan Kepala dan Pamong Asrama",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "51100",
            'code' => "51120",
            'title' => "Tunjangan Fungsional",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "51100",
            'code' => "51121",
            'title' => "Tunjangan Khusus Tenaga Pendidik TK/SD",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "51100",
            'code' => "51122",
            'title' => "Tunjangan Khusus Tenaga Kependidikan",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "51200",
            'code' => "51201",
            'title' => "Kelebihan Jam Mengajar",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "51200",
            'code' => "51202",
            'title' => "Penggantian Guru Cuti Melahirkan",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "51200",
            'code' => "51203",
            'title' => "Insentif Narasumber",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "51200",
            'code' => "51204",
            'title' => "Lembur Pegawai",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "51200",
            'code' => "51205",
            'title' => "Uang Transport",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "51200",
            'code' => "51206",
            'title' => "Uang Saku",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "51200",
            'code' => "51207",
            'title' => "Insentif Hari Raya",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "51200",
            'code' => "51208",
            'title' => "Vakasi Kegiatan",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "51200",
            'code' => "51209",
            'title' => "Tunjangan Pembina",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "51200",
            'code' => "51210",
            'title' => "Tunjangan Ketua Perwakilan dan Pengurus Perwakilan",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "51200",
            'code' => "51211",
            'title' => "Tunjangan Pengabdian",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "51200",
            'code' => "51212",
            'title' => "Tunjangan PNS",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "51200",
            'code' => "51213",
            'title' => "Tunjangan Kantor",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "51200",
            'code' => "51214",
            'title' => "Tunjangan Kehadiran",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "51200",
            'code' => "51215",
            'title' => "Insentif Pengelola BOS",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "51200",
            'code' => "51216",
            'title' => "Insentif Dapodik",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "51300",
            'code' => "51301",
            'title' => "Gaji Pegawai Tidak Tetap",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "51400",
            'code' => "51401",
            'title' => "Gaji Guru Ekstrakurikuler",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "51400",
            'code' => "51402",
            'title' => "Biaya Pendamping Ekstrakurikuler",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "51400",
            'code' => "51403",
            'title' => "Biaya Pendamping Intrakurikuler",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "51500",
            'code' => "51501",
            'title' => "Upah Tukang",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "51600",
            'code' => "51601",
            'title' => "Biaya Jasa",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "51700",
            'code' => "51701",
            'title' => "Biaya Jasa Konstruksi",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "52100",
            'code' => "52101",
            'title' => "Kegiatan PPDB",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "52100",
            'code' => "52102",
            'title' => "Kegiatan Open House",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "52100",
            'code' => "52103",
            'title' => "Kegiatan Pemantapan Ujian dan Try-out",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "52100",
            'code' => "52104",
            'title' => "Perkenalan Sekolah",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "52100",
            'code' => "52105",
            'title' => "Lembar Kerja Siswa",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "52200",
            'code' => "52201",
            'title' => "Pengembangan Kurikulum",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "52200",
            'code' => "52202",
            'title' => "Penyusunan Perangkat Pembelajaran",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "52300",
            'code' => "52301",
            'title' => "Kegiatan Pembelajaran PAIKEM/PAKEM",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "52300",
            'code' => "52302",
            'title' => "Kegiatan Ulangan Harian, Pengayaan dan Remedial",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "52300",
            'code' => "52303",
            'title' => "Kegiatan Kerohanian Siswa",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "52300",
            'code' => "52304",
            'title' => "Kegiatan Peningkatan Prestasi Siswa",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "52300",
            'code' => "52305",
            'title' => "Kegiatan Praktik / Prakerin Siswa",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "52300",
            'code' => "52306",
            'title' => "Kegiatan Ekstrakurikuler Sekolah",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "52300",
            'code' => "52307",
            'title' => "Kegiatan Ekstrakurikuler GKGP",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "52300",
            'code' => "52308",
            'title' => "Kegiatan Ekstrakurikuler Wayang Wahyu",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "52400",
            'code' => "52401",
            'title' => "Kegiatan Peningkatan Kompetensi Guru/Karyawan",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "52400",
            'code' => "52402",
            'title' => "Kegiatan Pengembangan Kepemimpinan",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "52400",
            'code' => "52403",
            'title' => "Kegiatan Pengembangan Iman",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "52400",
            'code' => "52404",
            'title' => "Biaya Perjalanan Dinas",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "52400",
            'code' => "52405",
            'title' => "Biaya Tiket, Bensin KendaraanTugas Dinas",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "52400",
            'code' => "52406",
            'title' => "Biaya Konsumsi Pendidik dan Tenaga Kependidikan",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "52500",
            'code' => "52501",
            'title' => "Pengadaan Buku Perpustakaan dan Pembelajaran",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "52500",
            'code' => "52502",
            'title' => "Pengadaan Buku Pegangan Guru",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "52500",
            'code' => "52503",
            'title' => "Pengadaan Buku Siswa",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "52500",
            'code' => "52504",
            'title' => "Pengadaan ATK",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "52500",
            'code' => "52505",
            'title' => "Pemeliharaan Peralatan dan Perlengkapan Sekolah",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "52500",
            'code' => "52506",
            'title' => "Renovasi Pemeliharaan Gedung",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "52500",
            'code' => "52507",
            'title' => "Perlengkapan Jaringan Komputer dan Listrik",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "52500",
            'code' => "52508",
            'title' => "Perlengkapan Kantor",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "52500",
            'code' => "52509",
            'title' => "Perlengkapan Laboratorium",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "52500",
            'code' => "52510",
            'title' => "Kebersihan Lingkungan",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "52600",
            'code' => "52601",
            'title' => "Kegiatan Akreditasi",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "52600",
            'code' => "52602",
            'title' => "Kegiatan ISO",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "52700",
            'code' => "52701",
            'title' => "Kegiatan Pertemuan dengan Wali Peserta Didik",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "52800",
            'code' => "52801",
            'title' => "Kegiatan Ujian Semesteran",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "52800",
            'code' => "52802",
            'title' => "Pelaksanaan Ujian Akhir",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "53100",
            'code' => "53101",
            'title' => "Beban Yadapen",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "53100",
            'code' => "53102",
            'title' => "Beban Pensiun",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "53100",
            'code' => "53103",
            'title' => "Beban Purna Bakti Pegawai",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "53100",
            'code' => "53104",
            'title' => "Beban Beasiswa ",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "53200",
            'code' => "53201",
            'title' => "Biaya Seragam",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "53200",
            'code' => "53202",
            'title' => "Biaya Majalah dan Koran",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "53200",
            'code' => "53203",
            'title' => "Biaya Fotocopy Kantor",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "53200",
            'code' => "53204",
            'title' => "Biaya Pembelian Barang Dagang",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "53300",
            'code' => "53301",
            'title' => "Biaya Makan Siswa Asrama",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "53300",
            'code' => "53302",
            'title' => "Biaya Makan Siswa TK",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "53400",
            'code' => "53401",
            'title' => "Kegiatan Sekolah",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "53400",
            'code' => "53402",
            'title' => "Perayaan Pelindung",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "53500",
            'code' => "53501",
            'title' => "Rekening Listrik",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "53500",
            'code' => "53502",
            'title' => "Rekening Telephone",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "53500",
            'code' => "53503",
            'title' => "Rekening Air",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "53500",
            'code' => "53504",
            'title' => "Rekening Internet",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "53600",
            'code' => "53601",
            'title' => "Pajak Kendaraan",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "53600",
            'code' => "53602",
            'title' => "Pajak Bumi dan Bangunan (PBB)",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "53600",
            'code' => "53603",
            'title' => "Pajak STP",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "53700",
            'code' => "53701",
            'title' => "Piutang Tak Tertagih DPP",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "53700",
            'code' => "53702",
            'title' => "Piutang Tak Tertagih UPP",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "53700",
            'code' => "53703",
            'title' => "Piutang Tak Tertagih Uang Sekolah",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "53700",
            'code' => "53704",
            'title' => "Piutang Tak Tertagih Uang Komputer",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "53700",
            'code' => "53705",
            'title' => "Piutang Tak Tertagih Uang Kegiatan",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "53700",
            'code' => "53706",
            'title' => "Piutang Tak Tertagih Uang Sarana Prasarana Pendidikan",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "53700",
            'code' => "53707",
            'title' => "Piutang Tak Tertagih Uang Asrama",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "53700",
            'code' => "53708",
            'title' => "Piutang Tak Tertagih Uang Komite",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "53700",
            'code' => "53709",
            'title' => "Piutang Tak Tertagih Pelangi Kasih",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "53700",
            'code' => "53710",
            'title' => "Piutang Tak Tertagih Antar Jemput",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "53700",
            'code' => "53711",
            'title' => "Piutang Tak Tertagih Seragam Siswa",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "53700",
            'code' => "53712",
            'title' => "Piutang Tak Tertagih Buku",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "53700",
            'code' => "53713",
            'title' => "Piutang Tak Tertagih Peralatan Sekolah",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "53700",
            'code' => "53714",
            'title' => "Piutang Tak Tertagih Kantin",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "53700",
            'code' => "53715",
            'title' => "Piutang Tak Tertagih UKB",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "53800",
            'code' => "53801",
            'title' => "Kerugian Penjualan Asset",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "53800",
            'code' => "53802",
            'title' => "Kerugian Investasi",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "53800",
            'code' => "53803",
            'title' => "Kerugian Selisih Kurs",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "53900",
            'code' => "53901",
            'title' => "Biaya Penyusutan Asset",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "53900",
            'code' => "53902",
            'title' => "Biaya Penyusutan Asset Dapem",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "54100",
            'code' => "54101",
            'title' => "Biaya Adminstrasi Dinas",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "54200",
            'code' => "54201",
            'title' => "Sumbangan Sosial",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "54200",
            'code' => "54202",
            'title' => "Santunan IDS",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "54200",
            'code' => "54203",
            'title' => "Uang Duka",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "54300",
            'code' => "54301",
            'title' => "Biaya Bunga Hutang",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "54300",
            'code' => "54302",
            'title' => "Biaya Pajak Bank",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "54300",
            'code' => "54303",
            'title' => "Biaya Administrasi Bank",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "54300",
            'code' => "54304",
            'title' => "Biaya Asuransi",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "54300",
            'code' => "54305",
            'title' => "Biaya Investasi Lainnya",
            'type' => 'D',
        ]);

        DB::table('prm_code_account')->insert([
            'group' => "54400",
            'code' => "54401",
            'title' => "Account Pambalance *",
            'type' => 'D',
        ]);

    }
}
