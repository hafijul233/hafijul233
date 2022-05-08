<?php

namespace Database\Factories\Backend\Portfolio;

use App\Models\Backend\Portfolio\Certificate;
use App\Supports\Constant;
use Illuminate\Database\Eloquent\Factories\Factory;

class CertificateFactory extends Factory
{
    protected $model = Certificate::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->paragraph(1),
            'organization' => $this->faker->company,
            'issue_date' => $this->faker->date(),
            'expire_date' => $this->faker->date(),
            'description' => $this->faker->paragraph(3),
            'enabled' => Constant::ENABLED_OPTION
        ];
    }
}
