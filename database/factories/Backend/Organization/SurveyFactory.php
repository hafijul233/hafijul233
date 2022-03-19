<?php

namespace Database\Factories\Backend\Organization;

use App\Models\Backend\Organization\Survey;
use Illuminate\Database\Eloquent\Factories\Factory;

class SurveyFactory extends Factory
{
    protected $model = Survey::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->paragraph(1)
        ];
    }
}
