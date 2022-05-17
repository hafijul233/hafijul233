<?php

namespace Database\Seeders\Backend\Setting;

use App\Models\Backend\Setting\Catalog;
use App\Supports\Constant;
use Illuminate\Database\Seeder;

class EmploymentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //https://au.indeed.com/career-advice/career-development/types-of-employment
        $catalogs = [
            [
                'type' => Constant::CATALOG_TYPE['EMPLOYMENT_TYPE'],
                'name' => 'Full Time',
                'remarks' => 'employment types',
                'additional_info' => [],
                'enabled' => Constant::ENABLED_OPTION
            ],
            [
                'type' => Constant::CATALOG_TYPE['EMPLOYMENT_TYPE'],
                'name' => 'Part Time',
                'remarks' => 'employment types',
                'additional_info' => [],
                'enabled' => Constant::ENABLED_OPTION
            ],
            [
                'type' => Constant::CATALOG_TYPE['EMPLOYMENT_TYPE'],
                'name' => 'Casual',
                'remarks' => 'employment types',
                'additional_info' => [],
                'enabled' => Constant::ENABLED_OPTION
            ],
            [
                'type' => Constant::CATALOG_TYPE['EMPLOYMENT_TYPE'],
                'name' => 'Contract',
                'remarks' => 'employment types',
                'additional_info' => [],
                'enabled' => Constant::ENABLED_OPTION
            ],
            [
                'type' => Constant::CATALOG_TYPE['EMPLOYMENT_TYPE'],
                'name' => 'Apprenticeship',
                'remarks' => 'employment types',
                'additional_info' => [],
                'enabled' => Constant::ENABLED_OPTION
            ],
            [
                'type' => Constant::CATALOG_TYPE['EMPLOYMENT_TYPE'],
                'name' => 'Traineeship',
                'remarks' => 'employment types',
                'additional_info' => [],
                'enabled' => Constant::ENABLED_OPTION
            ],
            [
                'type' => Constant::CATALOG_TYPE['EMPLOYMENT_TYPE'],
                'name' => 'Commission',
                'remarks' => 'employment types',
                'additional_info' => [],
                'enabled' => Constant::ENABLED_OPTION
            ],
            [
                'type' => Constant::CATALOG_TYPE['EMPLOYMENT_TYPE'],
                'name' => 'Probation',
                'remarks' => 'employment types',
                'additional_info' => [],
                'enabled' => Constant::ENABLED_OPTION
            ]
        ];

        foreach ($catalogs as $catalog):
            try {
                Catalog::create($catalog);
            } catch (\Exception $exception) {
                throw new \PDOException($exception->getMessage());
            }
        endforeach;
    }
}
