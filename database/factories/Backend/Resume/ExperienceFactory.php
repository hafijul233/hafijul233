<?php

namespace Database\Factories\Backend\Resume;

use App\Models\Backend\Resume\Experience;
use App\Models\Backend\Setting\Catalog;
use App\Supports\Constant;
use Illuminate\Database\Eloquent\Factories\Factory;

class ExperienceFactory extends Factory
{
    protected $model = Experience::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->jobTitle(),
            'employment_type_id' => Catalog::where('type', '=', Constant::CATALOG_TYPE['EMPLOYMENT_TYPE'])->inRandomOrder()->first()->id,
            'organization' => $this->faker->company(),
            'address' => $this->faker->streetAddress(),
            'url' => $this->faker->url,
            'start_date' => $this->faker->date(),
            'end_date' => $this->faker->date(),
            'description' => $this->faker->paragraph(3),
            'enabled' => Constant::ENABLED_OPTION
        ];
    }
}
