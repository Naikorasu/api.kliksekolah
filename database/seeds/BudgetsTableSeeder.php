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

        for($i=0; $i<=3; $i++) {
            DB::table('budgets')
                ->insert([
                    'periode' => '2020',
                    'create_by' => 'system@kliksekolah.com',
                    'desc' => $faker->paragraph,
                ]);

            for($z=0; $z<=100; $z++) {
                DB::table('budgets_detail')
                    ->insert([
                        'header' => $i+1,
                        'coa' => 51101,
                        'title' => 'GAJI STAFF ' . $faker->email,
                        'quantity' => $faker->randomNumber(3,false),
                        'price' => $faker->randomFloat(0,10000),
                        'term' => $faker->randomNumber(2,false),
                        'ypl' => $faker->randomFloat(0,10000),
                        'committee' => $faker->randomFloat(0,10000),
                        'intern' => $faker->randomFloat(0,10000),
                        'bos' => $faker->randomFloat(0,10000),
                        'total' => $faker->randomFloat(0,10000),
                        'desc' => $faker->paragraph,
                    ]);
            }
        }


    }
}
