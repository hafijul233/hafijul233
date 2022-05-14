<?php

namespace Database\Seeders\Backend\Portfolio;

use App\Models\Backend\Portfolio\Project;
use Database\Factories\Backend\Portfolio\ProjectFactory;
use Illuminate\Database\Seeder;

/**
 * Class CommentSeeder
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
        /**
         * @var ProjectFactory
         */
        Project::factory()->count(20)->create();
    }
}
