<?php

namespace Database\Seeders\Backend\Resume;

use App\Models\Backend\Resume\Language;
use Database\Factories\Backend\Resume\LanguageFactory;
use Illuminate\Database\Seeder;

/**
 * Class LanguageSeeder
 * @package Database\Seeders\Backend\Resume
 */
class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * @var LanguageFactory
         */
        Language::factory()->count(20)->create();
    }
}
