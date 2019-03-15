<?php

use Illuminate\Database\Seeder;

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

        for ($x = 1; $x <= 2; $x++) {

            $unique_id_head = generate_unique_key("system@kliksekolah.com;" . "HEAD;" . $x . ";" . $faker->sha1 . ";");

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
                $unique_id_account = generate_unique_key("system@kliksekolah.com;" . "ACCOUNT;" . $account_type . ";" . "$y" . ";" . $faker->sha1 . ";");

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

                DB::table('budgets_account')
                    ->insert([
                        'unique_id' => $unique_id_account,
                        'head' => $unique_id_head,
                        'account_type' => $account_type,
                        'account_info' => $account_info,
                    ]);


                for ($z = 1; $z <= 100; $z++) {

                    $code_of_account = $prefix_code_of_account . $faker->randomNumber(4);
                    $unique_id_detail = generate_unique_key("system@kliksekolah.com;" . "DETAIL;" . $code_of_account . ";" . $z . ";" . $faker->sha1 . ";");

                    DB::table('budgets_detail')
                        ->insert([
                            'unique_id' => $unique_id_detail,
                            'head' => $unique_id_head,
                            'account' => $unique_id_account,
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
                }
            }


        }


    }
}
