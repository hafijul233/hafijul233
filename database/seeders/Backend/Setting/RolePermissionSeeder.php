<?php

namespace Database\Seeders\Backend\Setting;

use App\Models\Backend\Setting\Permission;
use App\Models\Backend\Setting\Role;
use App\Supports\Constant;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    public $command = null;

    public function __construct()
    {
        $this->command = new Command();
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        //get all Routes
        $permissions = Permission::all();

        $superAdminRole = Role::findByName(Constant::SUPER_ADMIN_ROLE); //super admin

        $adminRole = Role::findByName('Administrator'); //admin

        $operatorRole = Role::findByName('Manager'); //manager&operator

        foreach ($permissions as $permission) :
            $superAdminRole->givePermissionTo($permission);

            if (strpos($permission->name, 'restore') === false) {
                $adminRole->givePermissionTo($permission);
                if ((strpos($permission->name, 'destroy') === false) &&
                    (strpos($permission->name, 'delete') === false)
                ) {
                    $operatorRole->givePermissionTo($permission);
                }
            }

        endforeach;
    }
}
