<?php

namespace Database\Seeders\Backend\Blog;

use App\Models\Backend\Blog\NewsLetter;
use Database\Factories\Backend\Blog\NewsLetterFactory;
use Illuminate\Database\Seeder;

class NewsLetterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * @var NewsLetterFactory
         */
        NewsLetter::factory()->count(20)->create();
    }
}
