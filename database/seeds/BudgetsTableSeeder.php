<?php

use Illuminate\Database\Seeder;
use App\Classes\FunctionHelper;

class BudgetsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $faker = \Faker\Factory::create();

        for ($x = 1; $x <= 10; $x++) {

            $fh = New FunctionHelper();
            $unique_id_head = $fh::generate_unique_key("system@kliksekolah.com;" . "HEAD;" . $x . ";");

            DB::table('budgets')
                ->insert([
                    'unique_id' => $unique_id_head,
                    'periode' => '2020',
                    'create_by' => 'system@kliksekolah.com',
                    'desc' => $faker->paragraph,
                ]);

            for ($y = 1; $y <= 5; $y++) {

                $prefix_code_of_account = $y;
                $account_type = $prefix_code_of_account . "0000";

                $fh = New FunctionHelper();
                $unique_id_account = $fh::generate_unique_key("system@kliksekolah.com;" . "ACCOUNT;" . $account_type . ";" . "$y" . ";");

                switch ($account_type) {
                    case '10000' :
                        $account_info = "AKTIVA";
                        break;

                    case '20000' :
                        $account_info = "PASIVA";
                        break;

                    case '30000' :
                        $account_info = "EKUITAS";
                        break;

                    case '40000' :
                        $account_info = "PENDAPATAN";
                        break;

                    case '50000' :
                        $account_info = "BEBAN";
                        break;

                    default:
                        break;
                }

                DB::table('budget_accounts')
                    ->insert([
                        'unique_id' => $unique_id_account,
                        'head' => $unique_id_head,
                        'account_type' => $account_type,
                        'account_info' => $account_info,
                    ]);


                for ($z = 1; $z <= 100; $z++) {

                    $code_of_account = $prefix_code_of_account . "1101";

                    $fh = New FunctionHelper();
                    $unique_id_detail = $fh::generate_unique_key("system@kliksekolah.com;" . "DETAIL;" . $code_of_account . ";" . $z . ";");

                    DB::table('budget_details')
                        ->insert([
                            'unique_id' => $unique_id_detail,
                            'head' => $unique_id_head,
                            'account' => $unique_id_account,
                            'semester' => $faker->boolean + 1,
                            'code_of_account' => $code_of_account,
                            'title' => $faker->sentence,
                            'quantity' => $faker->randomNumber(3, false),
                            'price' => $faker->randomFloat(0, 10000),
                            'term' => $faker->randomNumber(2, false),
                            'ypl' => $faker->randomFloat(0, 10000),
                            'committee' => $faker->randomFloat(0, 10000),
                            'intern' => $faker->randomFloat(0, 10000),
                            'bos' => $faker->randomFloat(0, 10000),
                            'total' => $faker->randomFloat(0, 10000),
                            'desc' => $faker->sentence,
                        ]);

                    DB::table('fund_requests')
                        ->insert([
                            'budget_detail_unique_id' => $unique_id_detail,
                            'amount' => $faker->randomFloat(0,10000),
                            'is_approved' => true,
                            'submitted' => true,
                            'user_id' => 1
                  ]);
                }
            }


        }


    }
}
