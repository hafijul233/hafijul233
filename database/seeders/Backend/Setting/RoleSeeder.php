<?php

namespace Database\Seeders\Backend\Setting;

use App\Models\Backend\Setting\Role;
use App\Supports\Constant;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'id' => 1,
            'name' => Constant::SUPER_ADMIN_ROLE,
            'remarks' => 'Role which will have all privileges.'
        ]);

        Role::create([
            'id' => 2,
            'name' => 'Administrator',
            'remarks' => 'Role which will have all privileges with out restore deleted data.'
        ]);

        Role::create([
            'id' => 3,
            'name' => 'Manager',
            'remarks' => 'Role which will have basic privileges and report generation.'
        ]);

        Role::create([
            'id' => 4,
            'name' => 'Post',
            'remarks' => 'Role which will have basic operation and minimal system options.'
        ]);
    }
}
