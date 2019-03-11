<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('users')->insert([
            'name' => "Naikorasu",
            'email' => "naikorasu@gmail.com",
            'password' => bcrypt('secret'),
        ]);

        DB::table('users')->insert([
            'name' => "Dharmadi",
            'email' => "dharmadi93@gmail.com",
            'password' => bcrypt('secret'),
        ]);

        DB::table('users')->insert([
            'name' => "Alex Winata",
            'email' => "alex.winata@kliksekolah.com",
            'password' => bcrypt('secret'),
        ]);

    }
}
