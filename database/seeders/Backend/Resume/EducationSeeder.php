<?php

namespace Database\Seeders\Backend\Resume;

use App\Models\Backend\Resume\Education;
use Database\Factories\Backend\Resume\EducationFactory;
use Illuminate\Database\Seeder;

/**
 * Class EducationSeeder
 * @package Database\Seeders\Backend\Resume
 */
class EducationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * @var EducationFactory
         */
        Education::factory()->count(20)->create();
    }
}
