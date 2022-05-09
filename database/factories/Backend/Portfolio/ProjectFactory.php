<?php

namespace Database\Factories\Backend\Portfolio;

use App\Models\Backend\Portfolio\Certificate;
use App\Models\Backend\Portfolio\Project;
use App\Supports\Constant;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    protected $model = Project::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->paragraph(1),
            'owner' => $this->faker->name,
            'url' => $this->faker->url,
            'associate' => $this->faker->company,
            'start_date' => $this->faker->date(),
            'end_date' => $this->faker->date(),
            'description' => $this->faker->paragraph(3),
            'enabled' => Constant::ENABLED_OPTION
        ];
    }
}
