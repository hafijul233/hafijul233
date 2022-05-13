<?php

namespace Database\Seeders\Backend\Resume;

use App\Models\Backend\Resume\Award;
use Database\Factories\Backend\Resume\AwardFactory;
use Illuminate\Database\Seeder;

/**
 * Class AwardSeeder
 * @package Database\Seeders\Backend\Resume
 */
class AwardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * @var AwardFactory
         */
        Award::factory()->count(20)->create();
    }
}
