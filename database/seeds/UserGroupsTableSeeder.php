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
        ], [
          'name' => 'Admin',
          'description' => 'Admin',
        ], [
          'name' => 'Keuangan Unit',
          'description' => 'Keuangan Unit',
        ], [
          'name' => 'Kepala Sekolah',
          'description' => 'Kepala Sekolah'
        ], [
          'name' => 'Ketua Perwakilan',
          'description' => 'Ketua Perwakilan',
        ], [
          'name' => 'Keuangan Pusat',
          'description' => 'Keuangan Pusat'
        ], [
          'name' => 'Bendahara',
          'description' => 'Bendahara'
        ]);
    }
}
