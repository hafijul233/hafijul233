<?php

namespace Database\Seeders\Backend;

use Database\Seeders\Backend\Blog\CommentSeeder;
use Database\Seeders\Backend\Blog\NewsLetterSeeder;
use Database\Seeders\Backend\Blog\PostSeeder;
use Exception;
use Illuminate\Database\Seeder;
use Throwable;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws Exception|Throwable
     */
    public function run()
    {
        $this->call(PostSeeder::class);
        $this->call(CommentSeeder::class);
        $this->call(NewsLetterSeeder::class);

    }
}
