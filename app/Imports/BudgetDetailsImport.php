<?php

namespace App\Imports;

use App\BudgetDetailDrafts;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\Importable;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithConditionalSheets;
use Maatwebsite\Excel\Concerns\WithStartRow;

class BudgetDetailsImport implements ToCollection, WithMultipleSheets, WithStartRow
{
    public $collection = [];

    public function collection(Collection $rows)
    {
      $semester = 2;
      $accountType = 40000;
      foreach($rows as $row) {
        $data = [];

        if(trim($row[0]) == 'B. Semester ke I Tahun Ajaran Berikutnya') {
          $semester = 1;
        } else {
          $semester = 2;
        }

        if(trim($row[0]) == 'Pengeluaran') {
          $accountType = 50000;
        } else if(trim($row[0]) == 'Inventaris') {
          $accountType = 13000;
        }

        if(is_float($row[0]) && !empty($row[0])) {
          $data['account_type'] = $accountType;
          $data['semester'] = $semester ;
          $data['code_of_account'] = intval($row[0]);
          $data['desc'] = $row[2];
          $data['quantity'] = $row[3];
          $data['price'] = floatval($row[4]);
          $data['term'] = intval($row[5]);
          $data['ypl'] = floatval($row[6]);
          $data['committee'] = floatval($row[7]);
          $data['intern'] = floatval($row[8]);
          $data['bos'] = floatval($row[9]);
          $data['total'] = floatval($row[10]);

          array_push($this->collection, $data);
        }
      }
    }

    public function startRow(): int {
      return 10;
    }

    public function sheets(): array {
        return [
            0 => $this,
        ];
    }
}
