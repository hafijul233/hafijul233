<?php

namespace Database\Factories\Backend\Blog;

use App\Models\Backend\Blog\Comment;
use App\Supports\Constant;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    protected $model = Comment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => 1,
            'post_id' => $this->faker->numberBetween(1, 20),
            'parent_id' => null,
            'message' => $this->faker->paragraph(5),
            'enabled' => Constant::ENABLED_OPTION
        ];
    }
}
