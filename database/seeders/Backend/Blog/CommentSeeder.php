<?php

namespace Database\Seeders\Backend\Blog;

use App\Models\Backend\Blog\Comment;
use Database\Factories\Backend\Blog\CommentFactory;
use Illuminate\Database\Seeder;

/**
 * Class CommentSeeder
 * @package Database\Seeders\Backend\Blog
 */
class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * @var CommentFactory
         */
        Comment::factory()->count(20)->create();
    }
}
