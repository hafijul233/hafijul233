<?php

namespace Database\Factories\Backend\Resume;

use App\Models\Backend\Resume\Skill;
use App\Supports\Constant;
use Illuminate\Database\Eloquent\Factories\Factory;

class SkillFactory extends Factory
{
    protected $model = Skill::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->jobTitle(),
            'percentage' => mt_rand(50, 100),
            'category_id' => mt_rand(50, 100),
            'enabled' => Constant::ENABLED_OPTION
        ];
    }
}
