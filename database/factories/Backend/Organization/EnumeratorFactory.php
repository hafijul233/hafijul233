<?php

namespace Database\Factories\Backend\Organization;

use App\Models\Backend\Organization\Survey;
use App\Models\Backend\Setting\Catalog;
use App\Supports\Constant;
use Illuminate\Database\Eloquent\Factories\Factory;

class EnumeratorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'survey_id' => Survey::all()->random()->id,
            'name' => $this->faker->name,
            'name_bd' => 'বাংলা নাম',
            'father' => $this->faker->name,
            'father_bd' => 'বাংলা নাম',
            'mother' => $this->faker->name,
            'mother_bd' => 'বাংলা নাম',
            'nid' => str_replace('+', '', $this->faker->e164PhoneNumber),
            'mobile_1' => str_replace('+', '0', $this->faker->e164PhoneNumber),
            'mobile_2' => str_replace('+', '0', $this->faker->e164PhoneNumber),
            'email' => $this->faker->email,
            'present_address' => $this->faker->address,
            'present_address_bd' => '১১  নং  কাতাসুর  মহহামদপুর  ঢাকা,১২০৭।',
            'permanent_address' => $this->faker->address,
            'permanent_address_bd' => '১১  নং  কাতাসুর  মহহামদপুর  ঢাকা,১২০৭।',
            'gender_id' => Catalog::where(['type' => 'GEN'])->get()->random()->id,
            'enabled' => Constant::ENABLED_OPTION
        ];
    }
}
