<?php

namespace Database\Seeders\Backend\Setting;

use App\Models\Backend\Setting\Catalog;
use App\Supports\Constant;
use Illuminate\Database\Seeder;

class GenderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $genders = [
            [

                'type' => Constant::CATALOG_TYPE['GENDER'],
                'name' => 'Male',
                'remarks' => 'n/a',
                'additional_info' => [],
                'enabled' => Constant::ENABLED_OPTION
            ],
            [
                'type' => Constant::CATALOG_TYPE['GENDER'],
                'name' => 'Female',
                'remarks' => 'n/a',
                'additional_info' => [],
                'enabled' => Constant::ENABLED_OPTION
            ],
        ];

        foreach ($genders as $gender):
            Catalog::create($gender);
            endforeach;
    }
}
