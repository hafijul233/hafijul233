<?php

namespace Database\Seeders\Backend\Setting;

use App\Models\Backend\Setting\Permission;
use App\Supports\Utility;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Route;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        //disable Observer
        $eventDispatcher = Permission::getEventDispatcher();
        Permission::unsetEventDispatcher();
        //get all routes
        $routes = array_keys(Route::getRoutes()->getRoutesByName());

        foreach ($routes as $route) {
            try {
                Permission::create(['display_name' => Utility::permissionDisplay($route), 'name' => $route, 'guard_name' => 'web', 'enabled' => 'yes']);
            } catch (\PDOException $exception) {
                throw new \PDOException($exception->getMessage());
            }
        }
        //Enable Observer
        Permission::setEventDispatcher($eventDispatcher);
    }
}
