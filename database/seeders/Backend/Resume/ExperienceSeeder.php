<?php

namespace Database\Seeders\Backend\Resume;

use App\Models\Backend\Resume\Experience;
use Database\Factories\Backend\Resume\ExperienceFactory;
use Illuminate\Database\Seeder;

/**
 * Class ExperienceSeeder
 * @package Database\Seeders\Backend\Resume
 */
class ExperienceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * @var ExperienceFactory
         */
        Experience::factory()->count(20)->create();
    }
}
