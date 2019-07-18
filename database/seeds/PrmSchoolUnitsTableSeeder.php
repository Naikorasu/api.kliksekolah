<?php

use Illuminate\Database\Seeder;
use App\SchoolUnits;

class PrmSchoolUnitsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $arr = array(
      	array(
      		"va_code" => "001",
      		"unit_code" => "A01",
      		"name" => "KANTOR YPL PERWAKILAN AMBARAWA"),
      	array(
      		"va_code" => "002",
      		"unit_code" => "A02",
      		"name" => "SD PL AMBARAWA"),
      	array(
      		"va_code" => "003",
      		"unit_code" => "A03",
      		"name" => "SMP PL AMBARAWA"),
      	array(
      		"va_code" => "004",
      		"unit_code" => "A04",
      		"name" => "ASRAMA ST. LOUIS AMB"),
      	array(
      		"va_code" => "005",
      		"unit_code" => "G02",
      		"name" => "SMP PL SALATIGA"),
      	array(
      		"va_code" => "006",
      		"unit_code" => "G03",
      		"name" => "SMP PL TLOGO"),
      	array(
      		"va_code" => "007",
      		"unit_code" => "B01",
      		"name" => "KANTOR YPL PERWAKILAN YOGYAKARTA"),
      	array(
      		"va_code" => "008",
      		"unit_code" => "B04",
      		"name" => "TK PL YOGYAKARTA"),
      	array(
      		"va_code" => "009",
      		"unit_code" => "B05",
      		"name" => "SD PL YOGYAKARTA"),
      	array(
      		"va_code" => "010",
      		"unit_code" => "B09",
      		"name" => "SMP PL YOGYAKARTA"),
      	array(
      		"va_code" => "011",
      		"unit_code" => "B10",
      		"name" => "SMA PL YOGYAKARTA"),
      	array(
      		"va_code" => "012",
      		"unit_code" => "C02",
      		"name" => "SD PL SEDAYU"),
      	array(
      		"va_code" => "013",
      		"unit_code" => "C03",
      		"name" => "SMP PL SEDAYU"),
      	array(
      		"va_code" => "014",
      		"unit_code" => "C04",
      		"name" => "SMP PL MOYUDAN"),
      	array(
      		"va_code" => "015",
      		"unit_code" => "C05",
      		"name" => "SMA PL SEDAYU"),
      	array(
      		"va_code" => "016",
      		"unit_code" => "C06",
      		"name" => "ASRAMA PUTRI ANGELA"),
      	array(
      		"va_code" => "017",
      		"unit_code" => "C07",
      		"name" => "ASRAMA PUTRA RUTTEN"),
      	array(
      		"va_code" => "018",
      		"unit_code" => "F04",
      		"name" => "SD PL 3 BORO"),
      	array(
      		"va_code" => "019",
      		"unit_code" => "F06",
      		"name" => "SMP PL BORO"),
      	array(
      		"va_code" => "020",
      		"unit_code" => "D01",
      		"name" => "KANTOR YPL PERWAKILAN KLATEN"),
      	array(
      		"va_code" => "021",
      		"unit_code" => "D02",
      		"name" => "SD PL KLATEN"),
      	array(
      		"va_code" => "022",
      		"unit_code" => "D03",
      		"name" => "SMK PL LEONARDO"),
      	array(
      		"va_code" => "023",
      		"unit_code" => "D04",
      		"name" => "SMP PL KLATEN"),
      	array(
      		"va_code" => "024",
      		"unit_code" => "D05",
      		"name" => "SMP PL WEDI"),
      	array(
      		"va_code" => "025",
      		"unit_code" => "D06",
      		"name" => "SMP PL BAYAT"),
      	array(
      		"va_code" => "026",
      		"unit_code" => "D07",
      		"name" => "SMP PL GANTIWARNO"),
      	array(
      		"va_code" => "027",
      		"unit_code" => "D08",
      		"name" => "SMP PL CAWAS"),
      	array(
      		"va_code" => "028",
      		"unit_code" => "D10",
      		"name" => "PG-TK PL KLATEN"),
      	array(
      		"va_code" => "029",
      		"unit_code" => "E01",
      		"name" => "KANTOR YPL PERWAKILAN MUNTILAN"),
      	array(
      		"va_code" => "030",
      		"unit_code" => "E02",
      		"name" => "KB/TK PL MUNTILAN"),
      	array(
      		"va_code" => "031",
      		"unit_code" => "E03",
      		"name" => "SD PL MUNTILAN"),
      	array(
      		"va_code" => "032",
      		"unit_code" => "E05",
      		"name" => "SMP PL MANDUNGAN"),
      	array(
      		"va_code" => "033",
      		"unit_code" => "E06",
      		"name" => "SMK PL MUNTILAN"),
      	array(
      		"va_code" => "034",
      		"unit_code" => "E07",
      		"name" => "SMA PL VAN LITH"),
      	array(
      		"va_code" => "035",
      		"unit_code" => "E10",
      		"name" => "ASRAMA PL VAN LITH"),
      	array(
      		"va_code" => "036",
      		"unit_code" => "I01",
      		"name" => "KANTOR YPL PERWAKILAN SURAKARTA"),
      	array(
      		"va_code" => "037",
      		"unit_code" => "I02",
      		"name" => "SD PL TIMOTIUS"),
      	array(
      		"va_code" => "038",
      		"unit_code" => "I04",
      		"name" => "SMP PL BINTANG LAUT"),
      	array(
      		"va_code" => "039",
      		"unit_code" => "I05",
      		"name" => "SMA PL YOSEF"),
      	array(
      		"va_code" => "040",
      		"unit_code" => "I06",
      		"name" => "KB TK PL VALENTINUS SURAKARTA"),
      	array(
      		"va_code" => "041",
      		"unit_code" => "I07",
      		"name" => "SD PL VALENTINUS SURAKARTA"),
      	array(
      		"va_code" => "042",
      		"unit_code" => "I08",
      		"name" => "SMP PL VINCENTIUS"),
      	array(
      		"va_code" => "043",
      		"unit_code" => "I09",
      		"name" => "SMA PL VINCENTIUS"),
      	array(
      		"va_code" => "044",
      		"unit_code" => "H02",
      		"name" => "TK PL DON BOSKO"),
      	array(
      		"va_code" => "045",
      		"unit_code" => "H03",
      		"name" => "SD PL DON BOSKO"),
      	array(
      		"va_code" => "046",
      		"unit_code" => "H04",
      		"name" => "SMA PL DON BOSKO"),
      	array(
      		"va_code" => "047",
      		"unit_code" => "J02",
      		"name" => "TK PL ST. YUSUP"),
      	array(
      		"va_code" => "048",
      		"unit_code" => "J03",
      		"name" => "SD PL ST. YUSUP"),
      	array(
      		"va_code" => "049",
      		"unit_code" => "J04",
      		"name" => "TK PL XAVERIUS"),
      	array(
      		"va_code" => "050",
      		"unit_code" => "J05",
      		"name" => "SD PL XAVERIUS"),
      	array(
      		"va_code" => "051",
      		"unit_code" => "J09",
      		"name" => "TK PL TARCISIUS"),
      	array(
      		"va_code" => "052",
      		"unit_code" => "J10",
      		"name" => "SD PL TARCISIUS"),
      	array(
      		"va_code" => "053",
      		"unit_code" => "J12",
      		"name" => "TK PL BERNARDUS"),
      	array(
      		"va_code" => "054",
      		"unit_code" => "J13",
      		"name" => "SD PL BERNARDUS"),
      	array(
      		"va_code" => "055",
      		"unit_code" => "J18",
      		"name" => "TK SD PL VINCENTIUS"),
      	array(
      		"va_code" => "056",
      		"unit_code" => "J20",
      		"name" => "TK SD PL SERVATIUS"),
      	array(
      		"va_code" => "057",
      		"unit_code" => "J21",
      		"name" => "SMP PL DOMENICO SAVIO"),
      	array(
      		"va_code" => "058",
      		"unit_code" => "J22",
      		"name" => "SMP PL BONIFASIO"),
      	array(
      		"va_code" => "059",
      		"unit_code" => "J24",
      		"name" => "SMA PL ST. LUKAS PEMALANG"),
      	array(
      		"va_code" => "060",
      		"unit_code" => "J25",
      		"name" => "TK PL ST. PIUS KARTINI"),
      	array(
      		"va_code" => "061",
      		"unit_code" => "J26",
      		"name" => "SMP PL ST. YUSUP MIJEN"),
      	array(
      		"va_code" => "062",
      		"unit_code" => "J27",
      		"name" => "SMK PL TARCISIUS 1"),
      	array(
      		"va_code" => "063",
      		"unit_code" => "K01",
      		"name" => "KANTOR YPL PERWAKILAN JAKARTA"),
      	array(
      		"va_code" => "064",
      		"unit_code" => "K02",
      		"name" => "TK PANGUDI LUHUR JAKARTA"),
      	array(
      		"va_code" => "065",
      		"unit_code" => "K03",
      		"name" => "SD PANGUDI LUHUR JAKARTA"),
      	array(
      		"va_code" => "066",
      		"unit_code" => "K04",
      		"name" => "SMP PANGUDI LUHUR JAKARTA"),
      	array(
      		"va_code" => "067",
      		"unit_code" => "K05",
      		"name" => "SMA PANGUDI LUHUR JAKARTA"),
      	array(
      		"va_code" => "068",
      		"unit_code" => "K06",
      		"name" => "SLB/B PANGUDI LUHUR JAKARTA"),
      	array(
      		"va_code" => "069",
      		"unit_code" => "K08",
      		"name" => "SMA PANGUDI LUHUR SERVASIUS"),
      	array(
      		"va_code" => "070",
      		"unit_code" => "K09",
      		"name" => "TK PANGUDI LUHUR BERNARDUS DELTAMAS"),
      	array(
      		"va_code" => "071",
      		"unit_code" => "K10",
      		"name" => "SD PANGUDI LUHUR BERNARDUS DELTAMAS"),
      	array(
      		"va_code" => "072",
      		"unit_code" => "K11",
      		"name" => "SMP PANGUDI LUHUR BERNARDUS DELTAMAS"),
      	array(
      		"va_code" => "073",
      		"unit_code" => "K12",
      		"name" => "SMA PANGUDI LUHUR BERNARDUS DELTAMAS"),
      	array(
      		"va_code" => "074",
      		"unit_code" => "L01",
      		"name" => "KANTOR YPL PERWAKILAN KETAPANG"),
      	array(
      		"va_code" => "075",
      		"unit_code" => "L02",
      		"name" => "SD PL YOSEF"),
      	array(
      		"va_code" => "076",
      		"unit_code" => "L03",
      		"name" => "SMP PL ALBERTUS"),
      	array(
      		"va_code" => "077",
      		"unit_code" => "L04",
      		"name" => "SMA PL YOHANES"),
      	array(
      		"va_code" => "078",
      		"unit_code" => "L05",
      		"name" => "PG TK PL ST. MARIA"),
      	array(
      		"va_code" => "079",
      		"unit_code" => "M02",
      		"name" => "SD PL  JUNGKAL"),
      	array(
      		"va_code" => "080",
      		"unit_code" => "M03",
      		"name" => "SD PL SERENGKAH"),
      	array(
      		"va_code" => "081",
      		"unit_code" => "M04",
      		"name" => "SD PL PS. MAYANG"),
      	array(
      		"va_code" => "082",
      		"unit_code" => "M05",
      		"name" => "SD PL NT PANJANG"),
      	array(
      		"va_code" => "083",
      		"unit_code" => "M06",
      		"name" => "SD PL SETIPAYAN"),
      	array(
      		"va_code" => "084",
      		"unit_code" => "M07",
      		"name" => "SMP PL TUMBANG TITI"),
      	array(
      		"va_code" => "085",
      		"unit_code" => "N02",
      		"name" => "SMP PL TANJUNG"),
      	array(
      		"va_code" => "086",
      		"unit_code" => "O03",
      		"name" => "KANTOR YPL PERWAKILAN SUKARAJA"),
      	array(
      		"va_code" => "087",
      		"unit_code" => "O02",
      		"name" => "SMA PL SUKARAJA"),
      	array(
      		"va_code" => "088",
      		"unit_code" => "O01",
      		"name" => "SMP PL SUKARAJA"),
      	array(
      		"va_code" => "089",
      		"unit_code" => "P01",
      		"name" => "KANTOR YPL PUSAT"),
      	array(
      		"va_code" => "090",
      		"unit_code" => "Q01",
      		"name" => "KANTOR PENGEMBANGAN SDM"),
      	array(
      		"va_code" => "091",
      		"unit_code" => "R01",
      		"name" => "ILP"),
      	array(
      		"va_code" => "092",
      		"unit_code" => "L06",
      		"name" => "Asrama WPK"),
      	array(
      		"va_code" => "093",
      		"unit_code" => "M08",
      		"name" => "Asrama Vincentius Tanjung"),
      	array(
      		"va_code" => "094",
      		"unit_code" => "N03",
      		"name" => "Asrama Sebastianus Tanjung"),
      	array(
      		"va_code" => "095",
      		"unit_code" => "O04",
      		"name" => "Asrama Pangudi Luhur Sukaraja")
      );

        SchoolUnits::insert($arr);
    }
}
