<?php

namespace Database\Seeders\Backend\Setting;

use App\Models\Backend\Setting\ExamLevel;
use App\Supports\Constant;
use Illuminate\Database\Seeder;

class ExamLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $exam_levels = [
            [
                'id' => '1',
                'name' => 'Secondary Level Education (SSC/ O-Level/ Equivalent)',
                'icon' => 'fas fa-school',
                'code' => 'ssc',
                'remarks' => 'n/a',
                'enabled' => Constant::ENABLED_OPTION
            ],
            [
                'id' => '2',
                'name' => 'Higher Secondary Level Education (HSC/ A-Level/ Equivalent)',
                'icon' => 'fas fa-laptop-code',
                'code' => 'hsc',
                'remarks' => 'n/a',
                'enabled' => Constant::ENABLED_OPTION
            ],
            [
                'id' => '3',
                'name' => 'Graduation or Equivalent Level',
                'icon' => 'fas fa-graduation-cap',
                'code' => 'gra',
                'remarks' => 'n/a',
                'enabled' => Constant::ENABLED_OPTION
            ],
            [
                'id' => '4',
                'name' => 'Post-Graduation or Equivalent Level',
                'icon' => 'fas fa-chalkboard-teacher',
                'code' => 'mas',
                'remarks' => 'n/a',
                'enabled' => Constant::ENABLED_OPTION
            ],
            [
                'id' => '5',
                'name' => 'Extra-Curricular/ Optional or Equivalent Level',
                'icon' => 'fas fa-book',
                'code' => 'ext',
                'remarks' => 'n/a',
                'enabled' => Constant::ENABLED_OPTION
            ]
        ];

        foreach ($exam_levels as $exam_level):
            ExamLevel::create($exam_level);
        endforeach;

    }
}
