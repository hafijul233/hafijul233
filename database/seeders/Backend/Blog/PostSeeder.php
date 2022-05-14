<?php

namespace Database\Seeders\Backend\Blog;

use App\Models\Backend\Blog\Post;
use Database\Factories\Backend\Blog\PostFactory;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * @var PostFactory
         */
        Post::factory()->count(20)->create();
    }
}
