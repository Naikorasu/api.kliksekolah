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
        UserGroups::insert([
          'name' => 'Super Admin',
          'description' => 'Super Admin',
          'priority' => 0
        ], [
          'name' => 'Admin',
          'description' => 'Admin',
          'priority' => 1
        ], [
          'name' => 'Keuangan Unit',
          'description' => 'Keuangan Unit',
          'priority' => 6
        ], [
          'name' => 'Kepala Sekolah',
          'description' => 'Kepala Sekolah',
          'priority' => 5
        ], [
          'name' => 'Ketua Perwakilan',
          'description' => 'Ketua Perwakilan',
          'priority' => 4
        ], [
          'name' => 'Keuangan Pusat',
          'description' => 'Keuangan Pusat',
          'priority' => 3
        ], [
          'name' => 'Bendahara',
          'description' => 'Bendahara',
          'priority' => 2
        ]);
    }
}
