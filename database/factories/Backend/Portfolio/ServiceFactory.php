<?php

namespace Database\Factories\Backend\Portfolio;

use App\Models\Backend\Portfolio\Service;
use App\Supports\Constant;
use Illuminate\Database\Eloquent\Factories\Factory;

class ServiceFactory extends Factory
{
    protected $model = Service::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->jobTitle(),
            'summary' => $this->faker->paragraph(5),
            'description' => $this->faker->randomHtml(20),
            'enabled' => Constant::ENABLED_OPTION
        ];
    }
}
