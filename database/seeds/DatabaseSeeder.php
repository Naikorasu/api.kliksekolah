<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);

        $this->call([
            //BudgetsTableSeeder::class,
            // ParameterTableSeeder::class,
            // PrmSchoolUnitsTableSeeder::class,
            //UserRolesTableSeeder::class,
            // PrmPerwakilanSeeder::class,
            // PrmSchoolUnitLinkPerwakilanSeeder::class
            //UserGroupsTableSeeder::class
        ]);
    }
}
