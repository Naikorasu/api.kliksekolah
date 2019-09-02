<?php

use Illuminate\Database\Seeder;
use App\Perwakilan;

class PrmPerwakilanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arr = [
          ['code'  =>  'A01',  'name' =>  'YPL PERWAKILAN AMBARAWA' ],
          ['code'  =>  'B01',  'name' =>  'YPL PERWAKILAN  YOGYAKARTA' ],
          ['code'  =>  'D01',  'name' =>  'YPL PERWAKILAN KLATEN' ],
          ['code'  =>  'E01',  'name' =>  'YPL PERWAKILAN MUNTILAN' ],
          ['code'  =>  'I01',  'name' =>  'YPL PERWAKILAN SURAKARTA' ],
          ['code'  =>  'J01',  'name' =>  'YPL PERWAKILAN SEMARANG' ],
          ['code'  =>  'K01',  'name' =>  'YPL PERWAKILAN JAKARTA' ],
          ['code'  =>  'L01',  'name' =>  'YPL PERWAKILAN KETAPANG' ],
          ['code'  =>  'O03',  'name' =>  'YPL PERWAKILAN SUKARAJA' ],
          ['code'  =>  'P01',  'name' =>  'YAYASAN PANGUDI LUHUR' ],
          ['code'  =>  'Q01',  'name' =>  'KANTOR PENGEMBANGAN SDM PL' ],
          ['code'  =>  'Y01',  'name' =>  'YPL PERWAKILAN' ]
        ];

        $data = Perwakilan::insert($arr);
    }
}
