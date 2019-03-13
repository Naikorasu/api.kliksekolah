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

        //CODE CLASS

        DB::table('prm_code_class')->insert([
            'class' => "10000",
            'title' => "AKTIVA",
        ]);

        DB::table('prm_code_class')->insert([
            'class' => "20000",
            'title' => "PASIVA",
        ]);

        DB::table('prm_code_class')->insert([
            'class' => "30000",
            'title' => "EKUITAS",
        ]);

        DB::table('prm_code_class')->insert([
            'class' => "40000",
            'title' => "PENDAPATAN",
        ]);

        DB::table('prm_code_class')->insert([
            'class' => "50000",
            'title' => "BEBAN",
        ]);


        //CODE CATEGORY

        DB::table('prm_code_category')->insert([
            'class' => "10000",
            'category' => "11000",
            'title' => "AKTIVA LANCAR",
        ]);

        DB::table('prm_code_category')->insert([
            'class' => "10000",
            'category' => "12000",
            'title' => "AKTIVA TIDAK LANCAR",
        ]);

        DB::table('prm_code_category')->insert([
            'class' => "10000",
            'category' => "13000",
            'title' => "AKTIVA TETAP",
        ]);

        DB::table('prm_code_category')->insert([
            'class' => "20000",
            'category' => "21000",
            'title' => "KEWAJIBAN",
        ]);

        DB::table('prm_code_category')->insert([
            'class' => "30000",
            'category' => "31000",
            'title' => "ASSET BERSIH",
        ]);

        DB::table('prm_code_category')->insert([
            'class' => "40000",
            'category' => "41000",
            'title' => "PENDAPATAN TERIKAT PERMANEN",
        ]);

        DB::table('prm_code_category')->insert([
            'class' => "40000",
            'category' => "42000",
            'title' => "PENDAPATAN TERIKAT TEMPORER",
        ]);

        DB::table('prm_code_category')->insert([
            'class' => "50000",
            'category' => "51000",
            'title' => "BELANJA JASA PEGAWAI",
        ]);

        DB::table('prm_code_category')->insert([
            'class' => "50000",
            'category' => "52000",
            'title' => "BEBAN PROGRAM PENDIDIKAN NASIONAL",
        ]);

        DB::table('prm_code_category')->insert([
            'class' => "50000",
            'category' => "53000",
            'title' => "BEBAN OPERASIONAL YAYASAN",
        ]);

        DB::table('prm_code_category')->insert([
            'class' => "50000",
            'category' => "54000",
            'title' => "BIAYA ADMINISTRASI UMUM",
        ]);



        //CODE GROUP

        DB::table('prm_code_group')->insert([
            'category' => "11000",
            'group' => "11100",
            'title' => "KAS",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "11000",
            'group' => "11200",
            'title' => "TABUNGAN",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "11000",
            'group' => "11300",
            'title' => "GIRO",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "11000",
            'group' => "11400",
            'title' => "DEPOSITO",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "11000",
            'group' => "11500",
            'title' => "PERSEDIAAN",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "11000",
            'group' => "11600",
            'title' => "PERLENGKAPAN",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "12000",
            'group' => "12100",
            'title' => "INVESTASI",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "12000",
            'group' => "12100",
            'title' => "INVESTASI",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "12000",
            'group' => "12200",
            'title' => "PIUTANG TERIKAT PERMANEN",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "12000",
            'group' => "12300",
            'title' => "PIUTANG TERIKAT TEMPORER",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "12000",
            'group' => "12400",
            'title' => "PIUTANG UNIT",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "12000",
            'group' => "12500",
            'title' => "PIUTANG PEGAWAI",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "12000",
            'group' => "12600",
            'title' => "PIUTANG LAIN",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "12000",
            'group' => "12700",
            'title' => "CADANGAN KERUGIAN PIUTANG PERMANEN",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "12000",
            'group' => "12800",
            'title' => "CADANGAN KERUGIAN PIUTANG TEMPORER",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "12000",
            'group' => "12900",
            'title' => "BIAYA DIBAYAR DIMUKA",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "12000",
            'group' => "12910",
            'title' => "AKTIVA TETAP TIDAK BERWUJUD",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "12000",
            'group' => "12920",
            'title' => "REKENING KORAN KANTOR",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "13000",
            'group' => "13100",
            'title' => "DANA BANGUNAN / PRASARANA YANG DIGUNAKAN",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "13000",
            'group' => "13200",
            'title' => "TANAH",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "13000",
            'group' => "13300",
            'title' => "BANGUNAN",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "13000",
            'group' => "13400",
            'title' => "INVENTARIS KELOMPOK I",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "13000",
            'group' => "13500",
            'title' => "INVENTARIS KELOMPOK II",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "13000",
            'group' => "13600",
            'title' => "AKUMULASI PENYUSUTAN DAPEM",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "13000",
            'group' => "13700",
            'title' => "AKUMULASI PENYUSUTAN BANGUNAN",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "13000",
            'group' => "13800",
            'title' => "AKUMULASI PENYUSUTAN KELOMPOK I",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "13000",
            'group' => "13900",
            'title' => "AKUMULASI PENYUSUTAN KELOMPOK II",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "13000",
            'group' => "13900",
            'title' => "AKUMULASI PENYUSUTAN KELOMPOK II",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "21000",
            'group' => "21100",
            'title' => "HUTANG PAJAK",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "21000",
            'group' => "21200",
            'title' => "HUTANG LAIN",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "21000",
            'group' => "21300",
            'title' => "JAMINAN KESEJAHTERAAN KARYAWAN",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "21000",
            'group' => "21400",
            'title' => "DANA ASOM",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "21000",
            'group' => "21500",
            'title' => "BIAYA YANG MASIH HARUS DIBAYAR",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "21000",
            'group' => "21600",
            'title' => "DANA BANGUNAN / PRASARANA YANG BLM DIGUNAKAN",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "21000",
            'group' => "21700",
            'title' => "PENDAPATAN DITERIMA DIMUKA PERMANEN",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "21000",
            'group' => "21800",
            'title' => "PENDAPATAN DITERIMA DIMUKA TEMPORER",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "31000",
            'group' => "31100",
            'title' => "ASSET BERSIH TIDAK TERIKAT",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "31000",
            'group' => "31200",
            'title' => "ASSET BERSIH TERIKAT",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "41000",
            'group' => "41100",
            'title' => "DANA PENGEMBANGAN PENDIDIKAN",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "41000",
            'group' => "41200",
            'title' => "UANG PERSIAPAN PENDIDIKAN",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "41000",
            'group' => "41300",
            'title' => "UANG SEKOLAH",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "41000",
            'group' => "41400",
            'title' => "UANG KOMPUTER",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "41000",
            'group' => "41500",
            'title' => "UANG KEGIATAN SISWA",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "41000",
            'group' => "41600",
            'title' => "UANG SARANA PRASARANA PENDIDIKAN",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "41000",
            'group' => "41700",
            'title' => "DANA ASRAMA",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "41000",
            'group' => "41100",
            'title' => "PENDAPATAN KOMITE SEKOLAH",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "42000",
            'group' => "42100",
            'title' => "PENDAPATAN PPDB",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "42000",
            'group' => "42200",
            'title' => "PENDAPATAN FASILATAS",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "42000",
            'group' => "42300",
            'title' => "PENDAPATAN PENJUALAN",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "42000",
            'group' => "42400",
            'title' => "PENERIMAAN RETRET",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "42000",
            'group' => "42500",
            'title' => "PENDAPATAN PEMANFAATAN ASSET",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "42000",
            'group' => "42600",
            'title' => "PENDAPATAN SUMBANGAN",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "42000",
            'group' => "42700",
            'title' => "PENDAPATAN BUNGA INVESTASI",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "42000",
            'group' => "42800",
            'title' => "PENDAPATAN LAIN-LAIN",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "51000",
            'group' => "51100",
            'title' => "PENGGAJIAN PEGAWAI TETAP",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "51000",
            'group' => "51200",
            'title' => "HONOR TIDAK RUTIN",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "51000",
            'group' => "51300",
            'title' => "PENGGAJIAN PEGAWAI TIDAK TETAP",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "51000",
            'group' => "51400",
            'title' => "PENGGAJIAN GURU EKSTRAKURIKULER",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "51000",
            'group' => "51500",
            'title' => "UPAH TUKANG",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "51000",
            'group' => "51600",
            'title' => "BIAYA JASA",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "51000",
            'group' => "51700",
            'title' => "BIAYA JASA KONSTRUKSI",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "52000",
            'group' => "52100",
            'title' => "PENGEMBANGAN KOMPETENSI KELULUSAN",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "52000",
            'group' => "52200",
            'title' => "PENGEMBANGAN STANDART ISI",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "52000",
            'group' => "52300",
            'title' => "PENGEMBANGAN STANDART PROSES",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "52000",
            'group' => "52400",
            'title' => "PENGEMBANGAN PENDIDIK DAN TENAGA KEPENDIDIKAN",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "52000",
            'group' => "52500",
            'title' => "PENGEMBANGAN SARANA DAN PRASARANA",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "52000",
            'group' => "52600",
            'title' => "PENGEMBANGAN IMPLEMENTASI MANAJEMEN",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "52000",
            'group' => "52700",
            'title' => "PENGEMBANGAN PENGGALIAN SUMBER DANA PENDIDIKAN",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "52000",
            'group' => "52800",
            'title' => "PENGEMBANGAN DAN IMPLEMENTASI SISTEM PENILAIAN",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "53000",
            'group' => "53100",
            'title' => "BEBAN YAYASAN",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "53000",
            'group' => "53200",
            'title' => "BEBAN KANTOR",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "53000",
            'group' => "53300",
            'title' => "BEBAN PENDIDIKAN DAN ASRAMA",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "53000",
            'group' => "53400",
            'title' => "KEGIATAN SEKOLAH",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "53000",
            'group' => "53500",
            'title' => "BEBAN LAYANAN DAYA DAN JASA",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "53000",
            'group' => "53600",
            'title' => "BEBAN PAJAK",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "53000",
            'group' => "53700",
            'title' => "PIUTANG TAK TERTAGIH PERMANENT",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "53000",
            'group' => "53800",
            'title' => "PIUTANG TAK TERTAGIH TEMPORER",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "53000",
            'group' => "53900",
            'title' => "BEBAN KERUGIAN ASSET",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "53000",
            'group' => "53910",
            'title' => "BIAYA PENYUSUTAN",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "54000",
            'group' => "54100",
            'title' => "BIAYA ADMINISTRASI",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "54000",
            'group' => "54200",
            'title' => "BIAYA SUMBANGAN SOSIAL",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "54000",
            'group' => "54300",
            'title' => "BIAYA INVESTASI",
        ]);

        DB::table('prm_code_group')->insert([
            'category' => "54000",
            'group' => "54500",
            'title' => "BIAYA PAMBALANCE",
        ]);






        //CODE ACCOUNT

        DB::table('prm_code_account')->insert([
            'group' => "11100",
            'code' => "11101",
            'title' => "Kas Tunai",
            'type' => 'D',
        ]);
    }
}
