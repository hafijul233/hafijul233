<?php

namespace Database\Seeders\Backend\Portfolio;

use App\Models\Backend\Portfolio\Project;
use Illuminate\Database\Seeder;

/**
 * Class ProjectSeeder
 * @package Database\Seeders\Backend\Portfolio
 */
class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Project::factory()->count(20)->create();
    }
}
