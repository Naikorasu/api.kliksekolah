<?php

use Illuminate\Database\Seeder;
use App\Roles;

class UserRolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = new Roles();
        $roles->name = 'editor';
        $roles->description = 'User who can edit';
        $roles->save();
        $roles = new Roles();
        $roles->name = 'submitter';
        $roles->description = 'User who can submit';
        $roles->save();
        $roles = new Roles();
        $roles->name = 'approver';
        $roles->description = 'User who can approve/reject';
        $roles->save();
    }
}
