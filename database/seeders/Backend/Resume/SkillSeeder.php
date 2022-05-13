<?php

namespace Database\Seeders\Backend\Resume;

use App\Models\Backend\Resume\Skill;
use Database\Factories\Backend\Resume\SkillFactory;
use Illuminate\Database\Seeder;

/**
 * Class SkillSeeder
 * @package Database\Seeders\Backend\Resume
 */
class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * @var SkillFactory
         */
        Skill::factory()->count(20)->create();
    }
}
