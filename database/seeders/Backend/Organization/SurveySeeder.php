<?php

namespace Database\Seeders\Backend\Organization;

use App\Models\Backend\Organization\Survey;
use Illuminate\Database\Seeder;

class SurveySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Survey::factory()->count(20)->create();
    }
}
