<?php

namespace Database\Factories\Backend\Blog;

use App\Models\Backend\Blog\Post;
use App\Supports\Constant;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->paragraph(2),
            'summary' => $this->faker->paragraph(10),
            'content' => $this->faker->randomHtml(30),
            'published_at' => $this->faker->dateTime(),
            'enabled' => Constant::ENABLED_OPTION
        ];
    }
}
