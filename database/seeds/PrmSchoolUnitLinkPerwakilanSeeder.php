<?php

use Illuminate\Database\Seeder;
use App\Perwakilan;
use App\SchoolUnits;

class PrmSchoolUnitLinkPerwakilanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $map = [
          'A01' => [
            'A01',
            'A02',
            'A03',
            'A04',
            'G02',
            'G03'
          ],
          'B01' => [
            'B01',
            'B04',
            'B05',
            'B09',
            'B10',
            'C02',
            'C03',
            'C04',
            'C05',
            'C06',
            'C07',
            'F01',
            'F02',
            'F04',
            'F05',
            'F06'
          ],
          'D01' => [
            'D02',
            'D03',
            'D04',
            'D05',
            'D06',
            'D07',
            'D08',
            'D09',
            'D10'
          ],
          'E01' => [
            'E01',
            'E02',
            'E03',
            'E05',
            'E06',
            'E07',
            'E08',
            'E09',
            'E10',
            'E11'
          ],
          'I01' => [
            'I01',
            'I02',
            'I04',
            'I05',
            'I06',
            'I07',
            'I08',
            'I09'
          ],
          'J01' => [
            'H02',
            'H03',
            'H04',
            'J01',
            'J02',
            'J03',
            'J04',
            'J05',
            'J09',
            'J10',
            'J12',
            'J13',
            'J18',
            'J19',
            'J20',
            'J21',
            'J22',
            'J23',
            'J24',
            'J25',
            'J26',
            'J27'
          ],
          'K01' => [
            'K01',
            'K02',
            'K03',
            'K04',
            'K05',
            'K06',
            'K07',
            'K08',
            'K09',
            'K10',
            'K11',
            'K12',
            'K13',
            'K14',
            'K15',
            'K16'
          ],
          'L01' => [
            'L01',
            'L02',
            'L03',
            'L04',
            'L05',
            'L06',
            'M01',
            'M02',
            'M03',
            'M04',
            'M05',
            'M06',
            'M07',
            'M08',
            'N02',
            'N03'
          ],
          'O03' => [
            'O01',
            'O02',
            'O03'
          ],
          'P01' => [
            'P01',
            'P02',
            'R01'
          ],
          'Q01' => [
            'Q01'
          ],
          'Y01' => [
            'Y01'
          ]
        ];

      foreach($map as $perwakilanCode => $unitCodes) {
        $perwakilan= Perwakilan::select('id')->where('code', $perwakilanCode)->first();
        SchoolUnits::whereIn('unit_code', $unitCodes)->update(['prm_perwakilan_id' => $perwakilan->id]);
      }
    }
}
