<?php

namespace Database\Factories\Backend\Resume;

use App\Models\Backend\Resume\Education;
use App\Supports\Constant;
use Illuminate\Database\Eloquent\Factories\Factory;

class EducationFactory extends Factory
{
    protected $model = Education::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'degree' => $this->faker->paragraph(1),
            'field' => $this->faker->paragraph(1),
            'grade' => mt_rand(1, 5),
            'institute' => $this->faker->company(),
            'start_date' => $this->faker->date(),
            'end_date' => $this->faker->date(),
            'activity' => $this->faker->paragraph(1),
            'description' => $this->faker->paragraph(5),
            'enabled' => Constant::ENABLED_OPTION
        ];
    }
}
