<?php

namespace Database\Seeders;

use Database\Seeders\Backend\Organization\SurveySeeder;
use Database\Seeders\Backend\Setting\BoardSeeder;
use Database\Seeders\Backend\Setting\CitySeeder;
use Database\Seeders\Backend\Setting\CountrySeeder;
use Database\Seeders\Backend\Setting\ExamGroupSeeder;
use Database\Seeders\Backend\Setting\ExamLevelSeeder;
use Database\Seeders\Backend\Setting\ExamTitleSeeder;
use Database\Seeders\Backend\Setting\GenderSeeder;
use Database\Seeders\Backend\Setting\InstituteSeeder;
use Database\Seeders\Backend\Setting\PermissionSeeder;
use Database\Seeders\Backend\Setting\RolePermissionSeeder;
use Database\Seeders\Backend\Setting\RoleSeeder;
use Database\Seeders\Backend\Setting\StateSeeder;
use Database\Seeders\Backend\Setting\UserSeeder;
use Database\Seeders\Backend\UserRegisterSeeder;
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
        $this->call(UserSeeder::class);
        $this->call(GenderSeeder::class);
        $this->call(BoardSeeder::class);
        $this->call(ExamLevelSeeder::class);
        $this->call(ExamTitleSeeder::class);
        $this->call(ExamGroupSeeder::class);
        $this->call(InstituteSeeder::class);
        $this->call(SurveySeeder::class);
/*        $this->call(EnumeratorSeeder::class);*/
        $this->call(UserRegisterSeeder::class);
        Model::reguard();
    }
}
