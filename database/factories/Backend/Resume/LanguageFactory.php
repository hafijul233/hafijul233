<?php

namespace Database\Factories\Backend\Resume;

use App\Models\Backend\Resume\Language;
use App\Supports\Constant;
use Illuminate\Database\Eloquent\Factories\Factory;

class LanguageFactory extends Factory
{
    protected $model = Language::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'level' => 'verbal',
            'enabled' => Constant::ENABLED_OPTION
        ];
    }
}
