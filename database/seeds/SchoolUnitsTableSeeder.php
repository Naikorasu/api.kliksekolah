<?php

use Illuminate\Database\Seeder;

class SchoolUnitsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        /*
        DB::table('prm_school_units')->insert([
            'code_acc' => "",
            'code_acb' => "",
            'code_cab' => "",
            'name' => "",
            'address' => "",
            'city' => "",
            'phone_1' => "",
            'phone_2' => "",
            'tu_name' => "",
            'ks_name' => "",
        ]);
        */

        DB::table('prm_school_units')->insert([
            'code_acc' => 'A01',
            'code_acb' => '',
            'code_cab' => 'J01',
            'name' => 'YPL PERWAKILAN AMBARAWA',
            'address' => 'Mgr Sugiyapranata 191',
            'city' => 'Ambarawa',
            'phone_1' => '',
            'phone_2' => '',
            'tu_name' => 'BR. HERMAN YOSEP SAGIMAN',
            'ks_name' => 'MARKUS PUJI RAHAYU',
        ]);

        DB::table('prm_school_units')->insert([
            'code_acc' => 'A02',
            'code_acb' => 'A01',
            'code_cab' => '',
            'name' => 'SD PL AMBARAWA',
            'address' => 'Jl. Mgr. Sugiyapranata No. 30',
            'city' => 'Ambarawa',
            'phone_1' => '0298-592480',
            'phone_2' => '0298-594825',
            'tu_name' => 'Yohanes Lana Panjaga,S.Pd.SD',
            'ks_name' => 'Veronica Dyah Puspita',
        ]);

        DB::table('prm_school_units')->insert([
            'code_acc' => 'A03',
            'code_acb' => 'A01',
            'code_cab' => '',
            'name' => 'SMP PL AMBARAWA',
            'address' => 'Jl. Sugiyapranata no. 191 Ambarawa 50614',
            'city' => 'Ambarawa',
            'phone_1' => 'Tlp 0298-591328',
            'phone_2' => 'Fax 0298-595094',
            'tu_name' => 'Br. Antonius Paryanto, FIC.',
            'ks_name' => 'F.Inda Kristianawati',
        ]);

        DB::table('prm_school_units')->insert([
            'code_acc' => 'B01',
            'code_acb' => '',
            'code_cab' => 'B01',
            'name' => 'YPL PERWAKILAN YOGYAKARTA',
            'address' => 'Jln. P. Senopati No. 18',
            'city' => 'Yogyakarta',
            'phone_1' => '0274-370310',
            'phone_2' => 'fax : 0274-450108',
            'tu_name' => 'Br. Herman Yosef, FIC',
            'ks_name' => 'Maria Kurniawati',
        ]);

        DB::table('prm_school_units')->insert([
            'code_acc' => 'B04',
            'code_acb' => 'B01',
            'code_cab' => '',
            'name' => 'TK PL YOGYAKARTA',
            'address' => 'Jln. P. Senopati No. 18',
            'city' => 'Yogyakarta',
            'phone_1' => '0274-412129',
            'phone_2' => '',
            'tu_name' => 'Anastasia Arum Sari D,S.Pd',
            'ks_name' => 'Lucia Septi Kusumastuti',
        ]);

        DB::table('prm_school_units')->insert([
            'code_acc' => 'B05',
            'code_acb' => 'B01',
            'code_cab' => '',
            'name' => 'SD PL YOGYAKARTA',
            'address' => 'Jln. P. Senopati No. 18',
            'city' => 'Yogyakarta',
            'phone_1' => '0274 - 385975',
            'phone_2' => '0274 - 378843',
            'tu_name' => 'Br. Fx Teguh Supono. FIC',
            'ks_name' => 'Al. Sukaca',
        ]);

        DB::table('prm_school_units')->insert([
            'code_acc' => 'B09',
            'code_acb' => 'B01',
            'code_cab' => '',
            'name' => 'SMP PL YOGYAKARTA',
            'address' => 'Jln. Timoho II / 29',
            'city' => 'Yogyakarta',
            'phone_1' => '0274-563552',
            'phone_2' => '0274-546061',
            'tu_name' => 'Br. Yosep Anton Utmiyadi FIC,',
            'ks_name' => 'A. Rustianwuri.',
        ]);

        DB::table('prm_school_units')->insert([
            'code_acc' => 'B10',
            'code_acb' => 'B01',
            'code_cab' => '',
            'name' => 'SMA PL YOGYAKARTA',
            'address' => 'Jln. P. Senopati No. 18',
            'city' => 'Yogyakarta',
            'phone_1' => '0274-370310',
            'phone_2' => 'fax : 0274-450108',
            'tu_name' => 'Andreas Mujiyono, S.Pd.',
            'ks_name' => 'Ragilia Wurdiniati',
        ]);

        DB::table('prm_school_units')->insert([
            'code_acc' => 'C02',
            'code_acb' => 'B01',
            'code_cab' => '',
            'name' => 'SD PL SEDAYU',
            'address' => 'Gubug, Argosari,Sedayu',
            'city' => 'Bantul',
            'phone_1' => '( 0274) 4546759',
            'phone_2' => '',
            'tu_name' => 'Anastasia Sri Lestari, S.Pd',
            'ks_name' => 'Agustina Rita Dewi Noviana',
        ]);

        DB::table('prm_school_units')->insert([
            'code_acc' => 'C03',
            'code_acb' => 'B01',
            'code_cab' => '',
            'name' => 'SMP PL SEDAYU',
            'address' => 'Jln. Wates Km. 12 Sedayu',
            'city' => 'Bantul',
            'phone_1' => '0274-6498419',
            'phone_2' => '',
            'tu_name' => 'Celsius Suhartanta,S.Pd',
            'ks_name' => 'Chicilia Sri Mulatati, S.E',
        ]);

        DB::table('prm_school_units')->insert([
            'code_acc' => 'C04',
            'code_acb' => 'B01',
            'code_cab' => '',
            'name' => 'SMP PL MOYUDAN',
            'address' => 'Mergan,Sumberagung, Moyudan',
            'city' => 'Yogyakarta',
            'phone_1' => '08282745085',
            'phone_2' => '081229312551',
            'tu_name' => 'Drs. Yohanes Junianto',
            'ks_name' => 'C. Suhartini, A.Md.',
        ]);

        DB::table('prm_school_units')->insert([
            'code_acc' => 'C05',
            'code_acb' => 'B01',
            'code_cab' => '',
            'name' => 'SMA PL SEDAYU',
            'address' => 'JL. Wates Km. 12 Argosari, Sedayu',
            'city' => 'Bantul',
            'phone_1' => '0274-7494179',
            'phone_2' => '',
            'tu_name' => 'Br. Agust. Mujiya, S.Pd, FIC',
            'ks_name' => 'K. Septiasih',
        ]);

        DB::table('prm_school_units')->insert([
            'code_acc' => 'D01',
            'code_acb' => '',
            'code_cab' => 'D01',
            'name' => 'YPL PERWAKILAN KLATEN',
            'address' => 'Jln. Dr. Wahidin No. 32',
            'city' => 'Klaten',
            'phone_1' => '0272-321217',
            'phone_2' => '',
            'tu_name' => 'Br Savio Gimo',
            'ks_name' => 'SAC. Baskoro',
        ]);

        DB::table('prm_school_units')->insert([
            'code_acc' => 'D02',
            'code_acb' => 'D01',
            'code_cab' => '',
            'name' => 'SD PL KLATEN',
            'address' => 'Jln. Mgr. Sugiyapranata - Sang',
            'city' => 'Klaten',
            'phone_1' => '0272-326433',
            'phone_2' => '',
            'tu_name' => 'Thomas Agung Wibowo, S.Pd',
            'ks_name' => 'Yosefita Ika Maharani',
        ]);

        DB::table('prm_school_units')->insert([
            'code_acc' => 'D03',
            'code_acb' => 'D01',
            'code_cab' => '',
            'name' => 'SMK PL LEONARDO KLATEN',
            'address' => 'Jln. Dr. Wahidin Sudiro Husodo No.30 Klt',
            'city' => 'Klaten',
            'phone_1' => '0272-321949',
            'phone_2' => '',
            'tu_name' => 'Br.Frans D Atmadja,S.Pd.,M.Pd.',
            'ks_name' => 'M.Nuning Widiati',
        ]);

        DB::table('prm_school_units')->insert([
            'code_acc' => 'D04',
            'code_acb' => 'D01',
            'code_cab' => '',
            'name' => 'SMP PL KLATEN',
            'address' => 'Jln. Dr. Wahidin No. 28',
            'city' => 'Klaten',
            'phone_1' => '0272 - 321768',
            'phone_2' => '',
            'tu_name' => 'BR. Antonius Hardianto, FIC',
            'ks_name' => 'M.M. Ria Wulandari',
        ]);

        DB::table('prm_school_units')->insert([
            'code_acc' => 'D05',
            'code_acb' => 'D01',
            'code_cab' => '',
            'name' => 'SMP PL WEDI KLATEN',
            'address' => 'Karangrejo, Pandes, Wedi',
            'city' => 'Klaten',
            'phone_1' => '0272-324343',
            'phone_2' => '',
            'tu_name' => 'Br. V. Vembriyanto, FIC',
            'ks_name' => 'C. Sofyanaandi Irawan',
        ]);

        DB::table('prm_school_units')->insert([
            'code_acc' => 'D06',
            'code_acb' => 'D01',
            'code_cab' => '',
            'name' => 'SMP PL BAYAT KLATEN',
            'address' => 'Bayat',
            'city' => 'Klaten',
            'phone_1' => '02728990131',
            'phone_2' => '02723148261',
            'tu_name' => 'FX. Heru Cahyana, S.Pd.',
            'ks_name' => 'Venanto Rio',
        ]);

        DB::table('prm_school_units')->insert([
            'code_acc' => 'D07',
            'code_acb' => 'D01',
            'code_cab' => '',
            'name' => 'SMP PL GANTIWARNO KLATEN',
            'address' => 'Gantiwarno',
            'city' => 'Klaten',
            'phone_1' => '0272 - 3101489',
            'phone_2' => '',
            'tu_name' => 'A. Iwan Triyono S.Pd',
            'ks_name' => 'Veronica Dewi Rino Abadi',
        ]);

        DB::table('prm_school_units')->insert([
            'code_acc' => 'D08',
            'code_acb' => 'D01',
            'code_cab' => '',
            'name' => 'SMP PL CAWAS KLATEN',
            'address' => 'Brangkal, Barepan, Cawas',
            'city' => 'Klaten',
            'phone_1' => '0272 - 898087',
            'phone_2' => '',
            'tu_name' => 'CHATARINA ENY SULISTYANTI, S.P',
            'ks_name' => 'ML. Sri Utami',
        ]);

        DB::table('prm_school_units')->insert([
            'code_acc' => 'E01',
            'code_acb' => '',
            'code_cab' => 'E01',
            'name' => 'YPL PERWAKILAN MUNTILAN',
            'address' => 'Jalan Kartini No. 2',
            'city' => 'Muntilan',
            'phone_1' => '0293 587699',
            'phone_2' => '',
            'tu_name' => 'Br. Titus Totok Tri N, FIC',
            'ks_name' => 'Lestari Sugiyarti',
        ]);

        DB::table('prm_school_units')->insert([
            'code_acc' => 'E02',
            'code_acb' => 'E01',
            'code_cab' => '',
            'name' => 'TK PL MUNTILAN',
            'address' => 'Jl. Kartini No. 4',
            'city' => 'Muntilan',
            'phone_1' => '0293 587778',
            'phone_2' => '',
            'tu_name' => 'V. K Deta Dewi S. Pd',
            'ks_name' => 'Theresia Listyaningsih',
        ]);

        DB::table('prm_school_units')->insert([
            'code_acc' => 'E03',
            'code_acb' => 'E01',
            'code_cab' => '',
            'name' => 'SD PL MUNTILAN',
            'address' => 'Jln. Kartini No. 4',
            'city' => 'Muntilan',
            'phone_1' => '( 0293 )587778',
            'phone_2' => '',
            'tu_name' => 'Br. Andrias Djoko Purnomo, FIC',
            'ks_name' => 'Theresia Listyaningsih',
        ]);

        DB::table('prm_school_units')->insert([
            'code_acc' => 'E05',
            'code_acb' => 'E01',
            'code_cab' => '',
            'name' => 'SMP PL MANDUNGAN MUNTILAN',
            'address' => 'Mandungan, Bringin, Srumbung',
            'city' => 'Muntilan',
            'phone_1' => '0293 - 585 253,',
            'phone_2' => '',
            'tu_name' => 'B. Rusdiyono, S.Pd',
            'ks_name' => 'F.X. Trisyanto W',
        ]);

        DB::table('prm_school_units')->insert([
            'code_acc' => 'E06',
            'code_acb' => 'E01',
            'code_cab' => '',
            'name' => 'SMK PL MUNTILAN',
            'address' => 'Jln. Talun KM. 01 Muntilan',
            'city' => 'Muntilan',
            'phone_1' => '0293 - 587867',
            'phone_2' => '0293 - 587185',
            'tu_name' => 'Br. Titus Totok Nugroho, ST',
            'ks_name' => 'MM. Anjar Sri Wahyuni',
        ]);

        DB::table('prm_school_units')->insert([
            'code_acc' => 'E07',
            'code_acb' => 'E01',
            'code_cab' => '',
            'name' => 'SMA PL VAN LITH MUNTILAN',
            'address' => 'Jln. Kartini No. 1 Muntilan - 56411',
            'city' => 'Muntilan',
            'phone_1' => '0293 - 587041',
            'phone_2' => '0293 - 586090',
            'tu_name' => 'Br. Martinus S Giri, M.Hum,FIC',
            'ks_name' => 'F. R. Winda Widyaningrum',
        ]);

        DB::table('prm_school_units')->insert([
            'code_acc' => 'E08',
            'code_acb' => 'E01',
            'code_cab' => '',
            'name' => 'UNIT PRODUKSI KAYU',
            'address' => 'Jln. Kartini No. 2',
            'city' => 'Muntilan',
            'phone_1' => '',
            'phone_2' => '',
            'tu_name' => 'Br.Edmondus FIC',
            'ks_name' => 'Lilik Nurhayati',
        ]);

        DB::table('prm_school_units')->insert([
            'code_acc' => 'E09',
            'code_acb' => 'E01',
            'code_cab' => '',
            'name' => 'UNIT PRODUKSI MESIN',
            'address' => 'Jln. Kartini 1',
            'city' => 'Muntilan',
            'phone_1' => '0293 - 586778',
            'phone_2' => '',
            'tu_name' => '',
            'ks_name' => '',
        ]);

        DB::table('prm_school_units')->insert([
            'code_acc' => 'F01',
            'code_acb' => 'B01',
            'code_cab' => '',
            'name' => 'YPL BORO',
            'address' => 'Boro - Kulonprogo',
            'city' => 'Kulonprogo',
            'phone_1' => '0822749900',
            'phone_2' => '',
            'tu_name' => '',
            'ks_name' => '',
        ]);

        DB::table('prm_school_units')->insert([
            'code_acc' => 'F02',
            'code_acb' => 'B01',
            'code_cab' => '',
            'name' => 'SD PL 1 BORO',
            'address' => 'Boro, Banjarsari, Kalibawang',
            'city' => 'Kulonprogo',
            'phone_1' => '08282779418',
            'phone_2' => '',
            'tu_name' => 'H.SUKIMAN ,S.Pd.',
            'ks_name' => 'C.ENI SUMINI',
        ]);

        DB::table('prm_school_units')->insert([
            'code_acc' => 'F04',
            'code_acb' => 'B01',
            'code_cab' => '',
            'name' => 'SD PL III BORO',
            'address' => 'Gejlig, Banjarasri, Kalibawang',
            'city' => 'Kulonprogo',
            'phone_1' => '08282929972',
            'phone_2' => '',
            'tu_name' => 'P.Sugeng Priyanto,S.Pd.',
            'ks_name' => 'Y.Hardito,S.Pd.',
        ]);

        DB::table('prm_school_units')->insert([
            'code_acc' => 'F05',
            'code_acb' => 'B01',
            'code_cab' => '',
            'name' => 'SD PL KALIREJO',
            'address' => '',
            'city' => '',
            'phone_1' => '',
            'phone_2' => '',
            'tu_name' => '',
            'ks_name' => '',
        ]);

        DB::table('prm_school_units')->insert([
            'code_acc' => 'F06',
            'code_acb' => 'B01',
            'code_cab' => '',
            'name' => 'SMP PL BORO',
            'address' => 'Boro, Banjarasri, Kalibawang',
            'city' => 'Kulon Progo',
            'phone_1' => '0274 - 7478564',
            'phone_2' => '',
            'tu_name' => 'Br. Yohanes Sumardi, S.Pd, FIC',
            'ks_name' => 'Ch. Eni Purwiyanti',
        ]);

        DB::table('prm_school_units')->insert([
            'code_acc' => 'G02',
            'code_acb' => 'A01',
            'code_cab' => '',
            'name' => 'SMP PL SALATIGA',
            'address' => 'Jln. P. Diponegoro No. 90',
            'city' => 'Salatiga',
            'phone_1' => '0298 - 325390',
            'phone_2' => '',
            'tu_name' => 'Ign. Wijayanto, M.Pd.',
            'ks_name' => 'Th. Saktiana Oktorita',
        ]);

        DB::table('prm_school_units')->insert([
            'code_acc' => 'G03',
            'code_acb' => 'A01',
            'code_cab' => '',
            'name' => 'SMP PL TLOGO',
            'address' => 'Jl. Raya Tuntang Bringin Km. 5 Ds. Tlogo',
            'city' => 'Tuntang',
            'phone_1' => '0298 - 7100034',
            'phone_2' => '',
            'tu_name' => 'Ch. Haryani, S.Si.',
            'ks_name' => 'E. Th. Rita Andriani',
        ]);

        DB::table('prm_school_units')->insert([
            'code_acc' => 'H01',
            'code_acb' => '',
            'code_cab' => 'J01',
            'name' => 'YPL PERWAKILAN CANDI',
            'address' => 'Jln. Sultan Agung No. 133',
            'city' => 'Semarang',
            'phone_1' => '024 - 8311015',
            'phone_2' => '',
            'tu_name' => '',
            'ks_name' => '',
        ]);

        DB::table('prm_school_units')->insert([
            'code_acc' => 'H02',
            'code_acb' => 'J01',
            'code_cab' => '',
            'name' => 'TK PL DON BOSCO',
            'address' => '',
            'city' => 'Semarang',
            'phone_1' => '024 - 8502973',
            'phone_2' => '',
            'tu_name' => 'Yuliana Poniyati, S.Pd',
            'ks_name' => 'FM Lilien Christiani , S.Psi',
        ]);

        DB::table('prm_school_units')->insert([
            'code_acc' => 'H03',
            'code_acb' => 'J01',
            'code_cab' => '',
            'name' => 'SD PL DON BOSCO',
            'address' => 'Jl. Sultan Agung 133',
            'city' => 'Semarang',
            'phone_1' => '024 - 8319196',
            'phone_2' => '',
            'tu_name' => 'Y. Agus Jumani, M.Pd.',
            'ks_name' => 'Maria Kristanti',
        ]);

        DB::table('prm_school_units')->insert([
            'code_acc' => 'H04',
            'code_acb' => 'J01',
            'code_cab' => '',
            'name' => 'SMA PL DON BOSCO',
            'address' => 'Jl. Sultan Agung no. 133',
            'city' => 'Semarang',
            'phone_1' => '024 - 8311015',
            'phone_2' => '',
            'tu_name' => 'Br. Ag. Giwal Santoso FIC, S.E',
            'ks_name' => 'M. Novita Arum',
        ]);

        DB::table('prm_school_units')->insert([
            'code_acc' => 'I01',
            'code_acb' => '',
            'code_cab' => 'I01',
            'name' => 'YPL PERWAKILAN SURAKARTA',
            'address' => 'Jl. Mgr. Soegijapranata No. 05',
            'city' => 'Surakarta',
            'phone_1' => 'Phone / Fax : (0271)',
            'phone_2' => '- 631782',
            'tu_name' => 'Br. Yohanes Sudaryono , FIC',
            'ks_name' => 'B. Murwanti',
        ]);

        DB::table('prm_school_units')->insert([
            'code_acc' => 'I02',
            'code_acb' => 'I01',
            'code_cab' => '',
            'name' => 'SD PL SALA',
            'address' => 'JL. Mgr. Sugiyopranoto 1',
            'city' => 'Surakarta',
            'phone_1' => '0271 - 645359',
            'phone_2' => '',
            'tu_name' => 'Br. Ignatius Dalimin, FIC',
            'ks_name' => 'C. Nila Apriyani',
        ]);

        DB::table('prm_school_units')->insert([
            'code_acc' => 'I04',
            'code_acb' => 'I01',
            'code_cab' => '',
            'name' => 'SMP PL BINTANG LAUT SALA',
            'address' => 'Jln. Brigjend Slamet Riyadi No. 94',
            'city' => 'Surakarta',
            'phone_1' => '(0271) 637274',
            'phone_2' => 'Fax (0271) 637274',
            'tu_name' => 'Br. Agustinus Sudarmadi, M.Pd',
            'ks_name' => 'M. Monika Aprillia SP.',
        ]);

        DB::table('prm_school_units')->insert([
            'code_acc' => 'I05',
            'code_acb' => 'I01',
            'code_cab' => '',
            'name' => 'SMA PL ST.YOSEF SALA',
            'address' => 'Jl. LU. Adisucipto',
            'city' => 'Surakarta',
            'phone_1' => '0271 - 710795',
            'phone_2' => '0271- 713312',
            'tu_name' => 'Br. Yohanes Sudaryono M.Pd., F',
            'ks_name' => 'Bonifasio Bima',
        ]);

        DB::table('prm_school_units')->insert([
            'code_acc' => 'I06',
            'code_acb' => 'I01',
            'code_cab' => '',
            'name' => 'TK PL SIDOREJO SALA',
            'address' => 'Jln. MT. Haryono No. 50',
            'city' => 'Surakarta',
            'phone_1' => '0271 - 728357',
            'phone_2' => '',
            'tu_name' => 'Anastasia Anjarwati, S.Pd.',
            'ks_name' => 'Silsilia Indah',
        ]);

        DB::table('prm_school_units')->insert([
            'code_acc' => 'I07',
            'code_acb' => 'I01',
            'code_cab' => '',
            'name' => 'SD PL SIDOREJO SALA',
            'address' => 'Jl. MT. Haryono No. 50',
            'city' => 'Surakarta',
            'phone_1' => '0271 - 724924',
            'phone_2' => '',
            'tu_name' => 'Yustina Dwi Purwanti, S.Pd',
            'ks_name' => 'Yasinta Riajeng',
        ]);

        DB::table('prm_school_units')->insert([
            'code_acc' => 'I08',
            'code_acb' => 'I01',
            'code_cab' => '',
            'name' => 'SMP PL GIROWOYO, WONOGIRI',
            'address' => 'Kotak Pos 4, Danan,Sendangagung,Giriwoyo',
            'city' => 'Wonogiri',
            'phone_1' => '0273 - 3301557',
            'phone_2' => '08282706270',
            'tu_name' => 'Drs.FX.Koko Tahwan Muswarno',
            'ks_name' => 'AN.SARMI',
        ]);

        DB::table('prm_school_units')->insert([
            'code_acc' => 'I09',
            'code_acb' => 'I01',
            'code_cab' => '',
            'name' => 'SMA PL GIRIWOYO, WONOGIRI',
            'address' => 'Kotak Pos 5, Sejati, Giriwoyo, Wonogiri',
            'city' => 'Giriwoyo',
            'phone_1' => '082892210187',
            'phone_2' => '',
            'tu_name' => 'Br. Arnoldus Masdiharjo, FIC.',
            'ks_name' => 'St. Sri Sunarti',
        ]);

        DB::table('prm_school_units')->insert([
            'code_acc' => 'J01',
            'code_acb' => '',
            'code_cab' => 'J01',
            'name' => 'YPL PERWAKILAN SEMARANG',
            'address' => 'Jl. Dr. Sutomo 4 Semarang',
            'city' => 'Semarang',
            'phone_1' => '024 - 831 40 04',
            'phone_2' => '024 - 831 78 06',
            'tu_name' => 'Drs. Br.Theodorus S, MA, FIC',
            'ks_name' => 'SAC. Baskoro',
        ]);

        DB::table('prm_school_units')->insert([
            'code_acc' => 'J02',
            'code_acb' => 'J01',
            'code_cab' => '',
            'name' => 'TK PL ST.YUSUF',
            'address' => 'Jl. Mataram 874 Semarang',
            'city' => 'Semarang',
            'phone_1' => '024 - 8315988',
            'phone_2' => '024 - 8455744',
            'tu_name' => 'Anna Maria Walsii, S.Pd',
            'ks_name' => 'Emerita Triatmawati P',
        ]);

        DB::table('prm_school_units')->insert([
            'code_acc' => 'J03',
            'code_acb' => 'J01',
            'code_cab' => '',
            'name' => 'SD PL ST.YUSUF',
            'address' => 'Jln. MT. Haryono No. 874',
            'city' => 'Semarang',
            'phone_1' => '024 - 8315988',
            'phone_2' => '',
            'tu_name' => 'Br. Markus Sujarwo, FIC',
            'ks_name' => 'Christina Ika Pratiwi',
        ]);

        DB::table('prm_school_units')->insert([
            'code_acc' => 'J04',
            'code_acb' => 'J01',
            'code_cab' => '',
            'name' => 'TK PL XAVERIUS',
            'address' => 'Jln. Dr. Cipto No. 91',
            'city' => 'Semarang',
            'phone_1' => '024 - 3588551',
            'phone_2' => '',
            'tu_name' => 'Florentina Nugraheni.S.Pd',
            'ks_name' => 'Anastasia Kusuma W., S.Psi',
        ]);

        DB::table('prm_school_units')->insert([
            'code_acc' => 'J05',
            'code_acb' => 'J01',
            'code_cab' => '',
            'name' => 'SD PL XAVERIUS',
            'address' => 'Jln. Dr. Cipto No. 91',
            'city' => 'Semarang',
            'phone_1' => '024 - 3515967',
            'phone_2' => '',
            'tu_name' => 'Victorianus Sutrisno, S.Pd',
            'ks_name' => 'Maria Diana Kartikawati',
        ]);

        DB::table('prm_school_units')->insert([
            'code_acc' => 'J09',
            'code_acb' => 'J01',
            'code_cab' => '',
            'name' => 'TK PL TARCISIUS',
            'address' => 'Jl. Muktiharjo Dalam No. 4',
            'city' => 'Semarang',
            'phone_1' => '024 - 6595448',
            'phone_2' => '',
            'tu_name' => 'G. Budiningsih',
            'ks_name' => 'Swesti Ari Legowo',
        ]);

        DB::table('prm_school_units')->insert([
            'code_acc' => 'J10',
            'code_acb' => 'J01',
            'code_cab' => '',
            'name' => 'SD PL TARCISIUS',
            'address' => 'Jln. Muktiharjo Dalam No. 4 Pedurungan',
            'city' => 'Semarang',
            'phone_1' => '024 - 6593774',
            'phone_2' => '',
            'tu_name' => 'FX. Suparman. SPd.',
            'ks_name' => 'Fransisca Indah Safitri',
        ]);

        DB::table('prm_school_units')->insert([
            'code_acc' => 'J12',
            'code_acb' => 'J01',
            'code_cab' => '',
            'name' => 'TK PL BERNARDUS',
            'address' => 'Jl. Dr. Sutomo No. 4',
            'city' => 'Semarang',
            'phone_1' => '024 - 8451357',
            'phone_2' => '',
            'tu_name' => 'Ratih Budiningrum Lusia, S.Pd.',
            'ks_name' => 'M.Y.Sunarti',
        ]);

        DB::table('prm_school_units')->insert([
            'code_acc' => 'J13',
            'code_acb' => 'J01',
            'code_cab' => '',
            'name' => 'SD PL BERNARDUS',
            'address' => 'Jl. Dr. Sutomo No. 4',
            'city' => 'Semarang',
            'phone_1' => '024 - 8310810',
            'phone_2' => '024 - 8451357',
            'tu_name' => 'Drs. Br. Petrus I Wayan Parsa,',
            'ks_name' => 'MY. Sunarti',
        ]);

        DB::table('prm_school_units')->insert([
            'code_acc' => 'J18',
            'code_acb' => 'J01',
            'code_cab' => '',
            'name' => 'TK/SD PL VINCENSIUS TENGGANG',
            'address' => 'Jl. Purwosari Raya',
            'city' => 'Semarang',
            'phone_1' => '024 - 6590434',
            'phone_2' => '',
            'tu_name' => 'Titus Ariyatma,S.Pd',
            'ks_name' => 'Th. Iud Susanti',
        ]);

        DB::table('prm_school_units')->insert([
            'code_acc' => 'J20',
            'code_acb' => 'J01',
            'code_cab' => '',
            'name' => 'TK/SD PL SERVATIUS',
            'address' => 'Jln. Dr. Sutomo No. 4',
            'city' => 'Semarang',
            'phone_1' => '024 - 8442701',
            'phone_2' => '-',
            'tu_name' => 'Agustinus Sarjan',
            'ks_name' => 'Indah Permata Sari',
        ]);

        DB::table('prm_school_units')->insert([
            'code_acc' => 'J21',
            'code_acb' => 'J01',
            'code_cab' => '',
            'name' => 'SMP PL DOMENICO SAVIO',
            'address' => 'Jl. Dr. Sutomo 6',
            'city' => 'Semarang',
            'phone_1' => '024 8315609',
            'phone_2' => '024 8412441',
            'tu_name' => 'Albertus Suwarto FIC,MPd',
            'ks_name' => 'Theresia Yeni Riswanti',
        ]);

        DB::table('prm_school_units')->insert([
            'code_acc' => 'J22',
            'code_acb' => 'J01',
            'code_cab' => '',
            'name' => 'SMP PL BONIFASIO',
            'address' => 'Jl. Muktiharjo Dalam',
            'city' => 'Semarang',
            'phone_1' => '024 - 6582004',
            'phone_2' => '',
            'tu_name' => 'Dra. Lucia Welas Asih',
            'ks_name' => 'C. Natal Indri Kristiana',
        ]);

        DB::table('prm_school_units')->insert([
            'code_acc' => 'J23',
            'code_acb' => 'J01',
            'code_cab' => '',
            'name' => 'SMA PL THOMAS AQUINO',
            'address' => '',
            'city' => 'Semarang',
            'phone_1' => '024 - 6582003',
            'phone_2' => '',
            'tu_name' => '',
            'ks_name' => '',
        ]);

        DB::table('prm_school_units')->insert([
            'code_acc' => 'J25',
            'code_acb' => 'J01',
            'code_cab' => '',
            'name' => 'TK PL KARTINI',
            'address' => 'Jl. Sambiroto X / 31',
            'city' => 'Semarang',
            'phone_1' => '0246725724',
            'phone_2' => '',
            'tu_name' => 'Veronica Sri Oetari, S. Pd. SD',
            'ks_name' => 'Veronica Sri Oetari, S. Pd. SD',
        ]);

        DB::table('prm_school_units')->insert([
            'code_acc' => 'J26',
            'code_acb' => 'J01',
            'code_cab' => '',
            'name' => 'SMP PL ST.YUSUF MIJEN',
            'address' => 'Jl. Raya Mijen',
            'city' => 'Semarang',
            'phone_1' => '02470783848',
            'phone_2' => '',
            'tu_name' => 'Th Tatik Haryani',
            'ks_name' => 'Ani Yusi Prastiwi',
        ]);

        DB::table('prm_school_units')->insert([
            'code_acc' => 'J27',
            'code_acb' => 'J01',
            'code_cab' => '',
            'name' => 'SMK PL TARCISIUS',
            'address' => 'Jln. Brigjend Katamso No. 49',
            'city' => 'Semarang',
            'phone_1' => '024 - 8412665',
            'phone_2' => '',
            'tu_name' => 'Ant. Arief Budianto, S.Pd',
            'ks_name' => 'Elisabet Kristina, SE',
        ]);

        DB::table('prm_school_units')->insert([
            'code_acc' => 'J24',
            'code_acb' => 'J01',
            'code_cab' => '',
            'name' => 'SMA ST.LUKAS',
            'address' => 'Jl. Pemuda No. 28',
            'city' => 'Pemalang',
            'phone_1' => '0284 - 324692',
            'phone_2' => '',
            'tu_name' => 'Br. Heribertus Triyanto, S.Pd,',
            'ks_name' => 'Yohana Yulita',
        ]);

        DB::table('prm_school_units')->insert([
            'code_acc' => 'K01',
            'code_acb' => '',
            'code_cab' => 'K01',
            'name' => 'YPL PERWAKILAN JAKARTA',
            'address' => 'Jl. Haji Nawi No. 21, Cilandak',
            'city' => 'Jakarta',
            'phone_1' => '021-75906565',
            'phone_2' => '',
            'tu_name' => 'Br. Flo. Widyo Rijanto, FIC',
            'ks_name' => 'Ferdinandus Budi Haris W',
        ]);

        DB::table('prm_school_units')->insert([
            'code_acc' => 'K02',
            'code_acb' => 'K01',
            'code_cab' => '',
            'name' => 'TK PL JAKARTA',
            'address' => 'Jl. Haji Nawi No. 21, Cilandak, JakSel',
            'city' => 'Jakarta',
            'phone_1' => '021 - 7660882',
            'phone_2' => '',
            'tu_name' => 'Y. Retno Estuningsih. S,Pd.',
            'ks_name' => 'Yuliana Suwarsi',
        ]);

        DB::table('prm_school_units')->insert([
            'code_acc' => 'K03',
            'code_acb' => 'K01',
            'code_cab' => '',
            'name' => 'SD PL JAKARTA',
            'address' => 'Jln. Haji Nawi No. 21, Cilandak',
            'city' => 'Jakarta',
            'phone_1' => '021 - 7513693',
            'phone_2' => '',
            'tu_name' => 'Br. Stephanus Ngadenan, FIC',
            'ks_name' => 'Novian Stevianus',
        ]);

        DB::table('prm_school_units')->insert([
            'code_acc' => 'K04',
            'code_acb' => 'K01',
            'code_cab' => '',
            'name' => 'SMP PL JAKARTA',
            'address' => 'Jln. Haji Nawi No. 21 Cilandak',
            'city' => 'Jakarta',
            'phone_1' => '021 - 7503379',
            'phone_2' => '021-75940279',
            'tu_name' => 'Br. Paulus Sumarno, FIC',
            'ks_name' => 'Yohanes Tri Kurniadi',
        ]);

        DB::table('prm_school_units')->insert([
            'code_acc' => 'K05',
            'code_acb' => 'K01',
            'code_cab' => '',
            'name' => 'SMA PL JAKARTA',
            'address' => 'Jl. Brawijaya IV/47, Kebayoran Baru',
            'city' => 'Jakarta',
            'phone_1' => '021 - 7243556',
            'phone_2' => '021 - 7232301',
            'tu_name' => 'Br. YB Purwanto, FIC., ST',
            'ks_name' => 'Murdiyani',
        ]);

        DB::table('prm_school_units')->insert([
            'code_acc' => 'K06',
            'code_acb' => 'K01',
            'code_cab' => '',
            'name' => 'SLB/B PL JAKARTA',
            'address' => 'Jln. Pesanggrahan 125, Kembangan',
            'city' => 'Jakarta Barat',
            'phone_1' => '021 - 5804223',
            'phone_2' => '021 - 5817156',
            'tu_name' => 'Br.Yohanes Sudarman, FIC',
            'ks_name' => 'T. Dimas Dwi Aditya',
        ]);

        DB::table('prm_school_units')->insert([
            'code_acc' => 'K07',
            'code_acb' => 'K01',
            'code_cab' => '',
            'name' => 'KANTOR YPL PERWAKILAN JAKARTA',
            'address' => 'Jln. Haji Nawi No. 21',
            'city' => 'Jakarta Selatan',
            'phone_1' => '021 - 75906565',
            'phone_2' => '',
            'tu_name' => '',
            'ks_name' => '',
        ]);

        DB::table('prm_school_units')->insert([
            'code_acc' => 'K08',
            'code_acb' => 'K01',
            'code_cab' => '',
            'name' => 'SMA PL SERVASIUS',
            'address' => 'Jln. Raya Kampung Sawah, Pabuaran',
            'city' => 'Bekasi',
            'phone_1' => '021 - 84593325',
            'phone_2' => '021 - 84593326',
            'tu_name' => 'Br. Leonardus Paryoto FIC',
            'ks_name' => 'Dixie Fajarwati',
        ]);

        DB::table('prm_school_units')->insert([
            'code_acc' => 'K09',
            'code_acb' => 'K01',
            'code_cab' => '',
            'name' => 'TK/SD PL DELTAMAS',
            'address' => 'Jl. Tol Jakarta - Cikampek KM. 37',
            'city' => 'Bekasi',
            'phone_1' => '021 -70601157',
            'phone_2' => '021 - 70208017',
            'tu_name' => 'BR. PETRUS PONIDI, FIC',
            'ks_name' => 'ADE SUTISNA',
        ]);

        DB::table('prm_school_units')->insert([
            'code_acc' => 'L01',
            'code_acb' => '',
            'code_cab' => 'L01',
            'name' => 'YPL PERWAKILAN KETAPANG',
            'address' => 'JL. A Yani 82',
            'city' => 'Ketapang',
            'phone_1' => '0534-34094',
            'phone_2' => 'Fax 0534-34094',
            'tu_name' => 'Br. VALENTINUS NARYO, FIC.,M.P',
            'ks_name' => 'Br. VALENTINUS NARYO, FIC.,M.P',
        ]);

        DB::table('prm_school_units')->insert([
            'code_acc' => 'L02',
            'code_acb' => 'L01',
            'code_cab' => '',
            'name' => 'SD PL ST.YOSEF',
            'address' => 'JL. Ahmad Yani No.88',
            'city' => 'Ketapang',
            'phone_1' => '0534-32763',
            'phone_2' => '',
            'tu_name' => 'Br.Bonifasius Kasmo R. FIC',
            'ks_name' => 'Yuliana Srilistyastuti',
        ]);

        DB::table('prm_school_units')->insert([
            'code_acc' => 'L03',
            'code_acb' => 'L01',
            'code_cab' => '',
            'name' => 'SMP PL ST.ALBERTUS',
            'address' => 'Jalan A. Yani 88A',
            'city' => 'Ketapang',
            'phone_1' => '0534-32713',
            'phone_2' => '',
            'tu_name' => 'Br. Y. WAHYU BINTARTO, FIC.',
            'ks_name' => 'ELIAS ALOK',
        ]);

        DB::table('prm_school_units')->insert([
            'code_acc' => 'L04',
            'code_acb' => 'L01',
            'code_cab' => '',
            'name' => 'SMA PL ST.YOHANES',
            'address' => 'Jl. Jendral S. Parman No. 3 Ketapang',
            'city' => 'Ketapang',
            'phone_1' => '0534 32684',
            'phone_2' => '0534 32685',
            'tu_name' => 'Br.Valentinus Naryo,FIC,M.Pd',
            'ks_name' => 'Yohanes Rasul Maridjo',
        ]);

        DB::table('prm_school_units')->insert([
            'code_acc' => 'L05',
            'code_acb' => 'L01',
            'code_cab' => '',
            'name' => 'TK PL SANTA MARIA KETAPANG',
            'address' => 'Jl. Ahmad Yani 88 Kal. Barat',
            'city' => 'Ketapang',
            'phone_1' => '( 0534 ) 33359',
            'phone_2' => '',
            'tu_name' => 'Theresia Sunarti, S. Pd',
            'ks_name' => 'F. Dyah Wanita Wulan. S.E',
        ]);

        DB::table('prm_school_units')->insert([
            'code_acc' => 'M01',
            'code_acb' => 'L01',
            'code_cab' => '',
            'name' => 'YPL PERWAKILAN TUMBANG TITI',
            'address' => '',
            'city' => 'Ketapang',
            'phone_1' => '',
            'phone_2' => '',
            'tu_name' => '',
            'ks_name' => '',
        ]);

        DB::table('prm_school_units')->insert([
            'code_acc' => 'M02',
            'code_acb' => 'L01',
            'code_cab' => '',
            'name' => 'SD PL JUNGKAL',
            'address' => 'Jungkal',
            'city' => 'Kalimantan Barat',
            'phone_1' => '',
            'phone_2' => '',
            'tu_name' => 'FX.SUDIMAN',
            'ks_name' => '',
        ]);

        DB::table('prm_school_units')->insert([
            'code_acc' => 'M03',
            'code_acb' => 'L01',
            'code_cab' => '',
            'name' => 'SD PL SERENGKAH',
            'address' => 'Serengkah',
            'city' => 'Kalimantan Barat',
            'phone_1' => '',
            'phone_2' => '',
            'tu_name' => 'P.NOYEN',
            'ks_name' => 'HERKULANUS JIMI',
        ]);

        DB::table('prm_school_units')->insert([
            'code_acc' => 'M04',
            'code_acb' => 'L01',
            'code_cab' => '',
            'name' => 'SD PL PASIR MAYANG',
            'address' => 'PASIR MAYANG',
            'city' => 'Kalimantan Barat',
            'phone_1' => '',
            'phone_2' => '',
            'tu_name' => 'St.Sagitarius, A.Ma',
            'ks_name' => 'YB.Wiranto',
        ]);

        DB::table('prm_school_units')->insert([
            'code_acc' => 'M05',
            'code_acb' => 'L01',
            'code_cab' => '',
            'name' => 'SD PL NATAI PANJANG',
            'address' => 'JL. Orang Kaya Gumbat Natai Panjang',
            'city' => 'Ketapang',
            'phone_1' => '082149812416',
            'phone_2' => '',
            'tu_name' => 'Tukiman',
            'ks_name' => '',
        ]);

        DB::table('prm_school_units')->insert([
            'code_acc' => 'M06',
            'code_acb' => 'L01',
            'code_cab' => '',
            'name' => 'SD PL SETIPAYAN',
            'address' => 'Setipayan',
            'city' => 'Kalimantan Barat',
            'phone_1' => '',
            'phone_2' => '',
            'tu_name' => 'R.ROSMINI',
            'ks_name' => 'ELIA MERDA',
        ]);

        DB::table('prm_school_units')->insert([
            'code_acc' => 'M07',
            'code_acb' => 'L01',
            'code_cab' => '',
            'name' => 'SMP PL TUMBANG TITI',
            'address' => 'TUMBANG TITI',
            'city' => 'Kalimantan Barat',
            'phone_1' => '-',
            'phone_2' => '-',
            'tu_name' => 'Br.Y.Sumardi',
            'ks_name' => 'A.Tri Raharjo',
        ]);

        DB::table('prm_school_units')->insert([
            'code_acc' => 'N02',
            'code_acb' => 'L01',
            'code_cab' => '',
            'name' => 'SMP PL TANJUNG',
            'address' => 'JL.MERDEKA 1, TELUK RUNJAI',
            'city' => 'TANJUNG',
            'phone_1' => '',
            'phone_2' => '',
            'tu_name' => 'BR. PB PURYOKO FIC',
            'ks_name' => 'YOHANA IRANAMI',
        ]);

        DB::table('prm_school_units')->insert([
            'code_acc' => 'O01',
            'code_acb' => 'O03',
            'code_cab' => '',
            'name' => 'SMP PL SUKARAJA',
            'address' => 'Sukaraja Buay Madang OKU Timur',
            'city' => 'Sumatra Selatan',
            'phone_1' => '-',
            'phone_2' => '-',
            'tu_name' => 'Br. Antonius Parjana, FIC',
            'ks_name' => 'S. Maryuliati',
        ]);

        DB::table('prm_school_units')->insert([
            'code_acc' => 'O02',
            'code_acb' => 'O03',
            'code_cab' => '',
            'name' => 'SMA PL SUKARAJA',
            'address' => 'Sukaraja',
            'city' => 'Sumatra Selatan',
            'phone_1' => '0813.02573.06617',
            'phone_2' => '',
            'tu_name' => 'BR. L. EDY WAHYUDI, FIC',
            'ks_name' => 'Mg.Sutrismi',
        ]);

        DB::table('prm_school_units')->insert([
            'code_acc' => 'O03',
            'code_acb' => '',
            'code_cab' => 'O03',
            'name' => 'YPL PERWAKILAN SUKARAJA',
            'address' => 'Sukaraja Buay Madang OKU Timur',
            'city' => 'Sumatera Selatan',
            'phone_1' => '',
            'phone_2' => '',
            'tu_name' => 'Br. Ant. Parjana, S. Pd., FIC',
            'ks_name' => 'Chrisantus Sudarmanto S.Pd',
        ]);

        DB::table('prm_school_units')->insert([
            'code_acc' => 'P01',
            'code_acb' => '',
            'code_cab' => 'P01',
            'name' => 'YAYASAN PANGUDI LUHUR',
            'address' => 'Jl. Dr Sutomo No. 4',
            'city' => 'Semarang',
            'phone_1' => '024-8314004',
            'phone_2' => '024-8317806',
            'tu_name' => 'Br. Hans Gendut, FIC',
            'ks_name' => 'Ag.Pudji Utami',
        ]);

        DB::table('prm_school_units')->insert([
            'code_acc' => 'D09',
            'code_acb' => 'D01',
            'code_cab' => '',
            'name' => 'UNIT PRODUKSI LEO GROUP',
            'address' => 'Jl. Dr. Wahidin No. 30',
            'city' => 'Klaten',
            'phone_1' => '0272 - 3211949',
            'phone_2' => '',
            'tu_name' => '',
            'ks_name' => '',
        ]);

        DB::table('prm_school_units')->insert([
            'code_acc' => 'J19',
            'code_acb' => 'J01',
            'code_cab' => '',
            'name' => 'SMK PL TARSISIUS 2',
            'address' => 'Jl. Muktiharjo Km. 3',
            'city' => 'Semarang',
            'phone_1' => '024 - 6582003',
            'phone_2' => '',
            'tu_name' => 'Drs. HJ. Rusyadi, M.Pd.',
            'ks_name' => 'HY. Darlan Sucipto',
        ]);

        DB::table('prm_school_units')->insert([
            'code_acc' => 'E10',
            'code_acb' => 'E01',
            'code_cab' => '',
            'name' => 'ASRAMA VAN LITH',
            'address' => 'Jl. Kartini No. 1',
            'city' => 'Muntilan',
            'phone_1' => '0293 - 586778',
            'phone_2' => '0293 - 586090',
            'tu_name' => 'Br. Robertus Koencoro, FIC',
            'ks_name' => 'Br. Yohanes Sugiyono, FIC',
        ]);

        DB::table('prm_school_units')->insert([
            'code_acc' => 'Q01',
            'code_acb' => '',
            'code_cab' => '',
            'name' => 'YPL PERWAKILAN CANDI',
            'address' => 'JL SULTAN AGUNG 133',
            'city' => 'SEMARANG',
            'phone_1' => '8315847',
            'phone_2' => '',
            'tu_name' => 'BR ANTON KARYADI',
            'ks_name' => 'BR HANS GENDUT',
        ]);

        DB::table('prm_school_units')->insert([
            'code_acc' => 'R01',
            'code_acb' => '',
            'code_cab' => '',
            'name' => 'I L P',
            'address' => '2',
            'city' => 'Semarang',
            'phone_1' => '',
            'phone_2' => '',
            'tu_name' => '',
            'ks_name' => 'FS Sulistyaningrum',
        ]);

        DB::table('prm_school_units')->insert([
            'code_acc' => 'P02',
            'code_acb' => '',
            'code_cab' => '',
            'name' => 'PROVINSIALAT FIC',
            'address' => '1',
            'city' => '',
            'phone_1' => '',
            'phone_2' => '',
            'tu_name' => '',
            'ks_name' => '',
        ]);

        DB::table('prm_school_units')->insert([
            'code_acc' => 'ZZZ',
            'code_acb' => 'P01',
            'code_cab' => '',
            'name' => 'TK/SD/SMP/SMA Coba',
            'address' => 'Jl. Tol Coba Coba',
            'city' => 'Testing',
            'phone_1' => '000 - 00000000',
            'phone_2' => '000 - 00000000',
            'tu_name' => 'Pak Admin',
            'ks_name' => 'Bu Admin',
        ]);

        DB::table('prm_school_units')->insert([
            'code_acc' => 'E11',
            'code_acb' => 'E01',
            'code_cab' => '',
            'name' => 'PPLM',
            'address' => '',
            'city' => 'Muntilan',
            'phone_1' => '',
            'phone_2' => '',
            'tu_name' => '',
            'ks_name' => '',
        ]);

        DB::table('prm_school_units')->insert([
            'code_acc' => 'A04',
            'code_acb' => 'A01',
            'code_cab' => '',
            'name' => 'ASRAMA SINT LOUIS AMBARAWA',
            'address' => 'Jl. Sugiyapranata no. 191 Ambarawa 50614',
            'city' => 'Ambarawa',
            'phone_1' => 'Tlp 0298-591328',
            'phone_2' => 'Fax 0298-595094',
            'tu_name' => 'Br. Antonius Paryanto FIC',
            'ks_name' => 'Br. Antonius Paryanto FIC',
        ]);

        DB::table('prm_school_units')->insert([
            'code_acc' => 'C06',
            'code_acb' => 'B01',
            'code_cab' => '',
            'name' => 'ASRAMA MGR RUTTEN SEDAYU',
            'address' => 'JL. Wates Km. 12 Argosari, Sedayu',
            'city' => 'Bantul',
            'phone_1' => '0274-7494179',
            'phone_2' => '',
            'tu_name' => 'Br. Agustinus Mujiya',
            'ks_name' => 'Br. Agustinus Mujiya',
        ]);

        DB::table('prm_school_units')->insert([
            'code_acc' => 'M08',
            'code_acb' => 'L01',
            'code_cab' => '',
            'name' => 'ASRAMA ST.VINCENTIUS TUMBANG TITI',
            'address' => 'TUMBANG TITI',
            'city' => 'Kalimantan Barat',
            'phone_1' => '-',
            'phone_2' => '-',
            'tu_name' => 'Br.F.Mujiono, FIC',
            'ks_name' => 'Br.Y.Margiyanto, FIC',
        ]);

        DB::table('prm_school_units')->insert([
            'code_acc' => 'N03',
            'code_acb' => 'L01',
            'code_cab' => '',
            'name' => 'ASRAMA ST.SEBASTIANUS TANJUNG',
            'address' => 'JL.MERDEKA 1, TELUK RUNJAI',
            'city' => 'JELAI HULU,TANJ',
            'phone_1' => '',
            'phone_2' => '',
            'tu_name' => 'BR. SURANTO,FIC',
            'ks_name' => '',
        ]);

        DB::table('prm_school_units')->insert([
            'code_acc' => 'L06',
            'code_acb' => 'L01',
            'code_cab' => '',
            'name' => 'ASRAMA WISMA PUTRA KUSUMA KETAPANG',
            'address' => 'Jl. Ahmad Yani 84 Ketapang',
            'city' => 'Ketapang',
            'phone_1' => '',
            'phone_2' => '',
            'tu_name' => 'Br ROMANUS PARYANTO, FIC',
            'ks_name' => 'Br. ROMANUS PARYANTO, FIC',
        ]);

        DB::table('prm_school_units')->insert([
            'code_acc' => 'C07',
            'code_acb' => 'B01',
            'code_cab' => '',
            'name' => 'ASRAMA ST.ANGELA SEDAYU',
            'address' => 'JL. Wates Km. 12 Argosari, Sedayu',
            'city' => 'Yogyakarta',
            'phone_1' => '0813392730182',
            'phone_2' => '',
            'tu_name' => 'Sr. Cornelia HK',
            'ks_name' => 'Sr. Lidia HK',
        ]);

        DB::table('prm_school_units')->insert([
            'code_acc' => 'D10',
            'code_acb' => 'D01',
            'code_cab' => '',
            'name' => 'TK PL SUGIJAPRANATA KLATEN',
            'address' => 'Jln. Mgr. Sugiyapranata - Sang',
            'city' => 'Klaten',
            'phone_1' => '0272 -326433',
            'phone_2' => '',
            'tu_name' => 'Maria Puji Lestari, S.S',
            'ks_name' => 'Yosefita Ika Maharani Saputra',
        ]);

    }
}
