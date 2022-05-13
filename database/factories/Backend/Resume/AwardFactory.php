<?php

namespace Database\Factories\Backend\Resume;

use App\Models\Backend\Resume\Award;
use App\Supports\Constant;
use Illuminate\Database\Eloquent\Factories\Factory;

class AwardFactory extends Factory
{
    protected $model = Award::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->paragraph(1),
            'associate' => $this->faker->company(),
            'issuer' => $this->faker->company() . ' ' . $this->faker->companySuffix(),
            'issue_date' => $this->faker->date(),
            'description' => $this->faker->randomHtml(20),
            'enabled' => Constant::ENABLED_OPTION
        ];
    }
}
