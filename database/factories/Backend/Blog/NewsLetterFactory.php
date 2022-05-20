<?php

namespace Database\Factories\Backend\Blog;

use App\Models\Backend\Blog\NewsLetter;
use App\Supports\Constant;
use Illuminate\Database\Eloquent\Factories\Factory;

class NewsLetterFactory extends Factory
{
    protected $model = NewsLetter::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'mobile' => $this->faker->e164PhoneNumber(),
            'message' => $this->faker->paragraph(5),
            'enabled' => Constant::ENABLED_OPTION
        ];
    }
}
