<?php

namespace Database\Seeders\Backend;

use Database\Seeders\Backend\Resume\AwardSeeder;
use Database\Seeders\Backend\Resume\EducationSeeder;
use Database\Seeders\Backend\Resume\ExperienceSeeder;
use Database\Seeders\Backend\Resume\LanguageSeeder;
use Database\Seeders\Backend\Resume\SkillSeeder;
use Exception;
use Illuminate\Database\Seeder;
use Throwable;

class ResumeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws Exception|Throwable
     */
    public function run()
    {
        $this->call(ExperienceSeeder::class);
        $this->call(EducationSeeder::class);
        $this->call(AwardSeeder::class);
        $this->call(SkillSeeder::class);
        $this->call(LanguageSeeder::class);
    }
}
