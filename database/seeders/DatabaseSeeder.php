<?php

namespace Database\Seeders;

use Database\Seeders\Backend\AdminRegisterSeeder;
use Database\Seeders\Backend\Portfolio\CertificateSeeder;
use Database\Seeders\Backend\Portfolio\ServiceSeeder;
use Database\Seeders\Backend\SARegisterSeeder;
use Database\Seeders\Backend\Setting\CitySeeder;
use Database\Seeders\Backend\Setting\CountrySeeder;
use Database\Seeders\Backend\Setting\PermissionSeeder;
use Database\Seeders\Backend\Setting\RolePermissionSeeder;
use Database\Seeders\Backend\Setting\RoleSeeder;
use Database\Seeders\Backend\Setting\StateSeeder;
use Illuminate\Database\Eloquent\Model;
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
        Model::unguard();
        $this->call(CountrySeeder::class);
        $this->call(StateSeeder::class);
        $this->call(CitySeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(RolePermissionSeeder::class);
        $this->call(SARegisterSeeder::class);
        $this->call(AdminRegisterSeeder::class);
        $this->call(ServiceSeeder::class);
        $this->call(CertificateSeeder::class);
        Model::reguard();
    }
}
