<?php

namespace Database\Seeders;

use Database\Seeders\Backend\BlogSeeder;
use Database\Seeders\Backend\PortfolioSeeder;
use Database\Seeders\Backend\ResumeSeeder;
use Database\Seeders\Backend\SettingSeeder;
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
        $this->call(SettingSeeder::class);
        $this->call(PortfolioSeeder::class);
        $this->call(ResumeSeeder::class);
        $this->call(BlogSeeder::class);
        Model::reguard();
    }
}
