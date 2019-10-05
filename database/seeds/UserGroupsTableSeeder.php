<?php

use Illuminate\Database\Seeder;
use App\UserGroups;

class UserGroupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserGroups::create([
          'name' => 'Bendahara',
          'description' => 'Bendahara',
          'priority' => 2
        ]);
        // UserGroups::insert([
        //   'name' => 'Korektor Perwakilan',
        //   'description' => 'Korektor Perwakilan',
        //   'priority' => 4
        // ]);
    }
}
