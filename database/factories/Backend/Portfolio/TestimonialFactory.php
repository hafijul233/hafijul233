<?php

namespace Database\Factories\Backend\Portfolio;

use App\Models\Backend\Portfolio\Service;
use App\Models\Backend\Portfolio\Testimonial;
use App\Supports\Constant;
use Illuminate\Database\Eloquent\Factories\Factory;

class TestimonialFactory extends Factory
{
    protected $model = Testimonial::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'client' => $this->faker->name,
            'feedback' => $this->faker->paragraph(5),
            'enabled' => Constant::ENABLED_OPTION
        ];
    }
}
