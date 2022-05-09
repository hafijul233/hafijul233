<?php

namespace Database\Seeders\Backend;

use Database\Seeders\Backend\Setting\CitySeeder;
use Database\Seeders\Backend\Setting\CountrySeeder;
use Database\Seeders\Backend\Setting\PermissionSeeder;
use Database\Seeders\Backend\Setting\RolePermissionSeeder;
use Database\Seeders\Backend\Setting\RoleSeeder;
use Database\Seeders\Backend\Setting\StateSeeder;
use Exception;
use Illuminate\Database\Seeder;
use Throwable;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws Exception|Throwable
     */
    public function run()
    {
        $this->call(CountrySeeder::class);
        $this->call(StateSeeder::class);
        $this->call(CitySeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(RolePermissionSeeder::class);
        $this->call(SARegisterSeeder::class);
        $this->call(AdminRegisterSeeder::class);
    }
}
