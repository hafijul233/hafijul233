<?php

namespace Database\Seeders\Backend\Setting;

use App\Models\Backend\Setting\ExamTitle;
use Illuminate\Database\Seeder;

class ExamTitleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $exam_titles = [
            ['name' => 'Secondary School Certificate', 'remarks' => 'n/a', 'enabled' => 'yes', 'exam_level_id' => '1'],
            ['name' => 'Dakhil', 'remarks' => 'n/a', 'enabled' => 'yes', 'exam_level_id' => '1'],
            ['name' => 'S.S.C Vocational', 'remarks' => 'n/a', 'enabled' => 'yes', 'exam_level_id' => '1'],
            ['name' => 'O Level/Cambridge', 'remarks' => 'n/a', 'enabled' => 'yes', 'exam_level_id' => '1'],
            ['name' => 'S.S.C Equivalent', 'remarks' => 'n/a', 'enabled' => 'yes', 'exam_level_id' => '1'],
            ['name' => 'Trade Certificate', 'remarks' => 'n/a', 'enabled' => 'yes', 'exam_level_id' => '1'],
            ['name' => 'Higher School Secondary Certificate', 'remarks' => 'n/a', 'enabled' => 'yes', 'exam_level_id' => '2'],
            ['name' => 'Business Management', 'remarks' => 'n/a', 'enabled' => 'yes', 'exam_level_id' => '2'],
            ['name' => 'Diploma in Engineering', 'remarks' => 'n/a', 'enabled' => 'yes', 'exam_level_id' => '2'],
            ['name' => 'A Level/Sr. Cambridge', 'remarks' => 'n/a', 'enabled' => 'yes', 'exam_level_id' => '2'],
            ['name' => 'H.S.C Equivalent', 'remarks' => 'n/a', 'enabled' => 'yes', 'exam_level_id' => '2'],
            ['name' => 'Alim', 'remarks' => 'n/a', 'enabled' => 'yes', 'exam_level_id' => '2'],
            ['name' => 'B.A (Honors)', 'remarks' => 'n/a', 'enabled' => 'yes', 'exam_level_id' => '3'],
            ['name' => 'B.A (Pass Course)', 'remarks' => 'n/a', 'enabled' => 'yes', 'exam_level_id' => '3'],
            ['name' => 'B.Com (Honors)', 'remarks' => 'n/a', 'enabled' => 'yes', 'exam_level_id' => '3'],
            ['name' => 'B.Com (Pass Course)', 'remarks' => 'n/a', 'enabled' => 'yes', 'exam_level_id' => '3'],
            ['name' => 'B.Ed (Honors)', 'remarks' => 'n/a', 'enabled' => 'yes', 'exam_level_id' => '3'],
            ['name' => 'B.S.S (Honors)', 'remarks' => 'n/a', 'enabled' => 'yes', 'exam_level_id' => '3'],
            ['name' => 'B.S.S (Pass Course)', 'remarks' => 'n/a', 'enabled' => 'yes', 'exam_level_id' => '3'],
            ['name' => 'B.Sc (Agricultural Science)', 'remarks' => 'n/a', 'enabled' => 'yes', 'exam_level_id' => '3'],
            ['name' => 'B.Sc (Engineering/Architecture)', 'remarks' => 'n/a', 'enabled' => 'yes', 'exam_level_id' => '3'],
            ['name' => 'B.Sc (Honors)', 'remarks' => 'n/a', 'enabled' => 'yes', 'exam_level_id' => '3'],
            ['name' => 'B.Sc (Pass Course)', 'remarks' => 'n/a', 'enabled' => 'yes', 'exam_level_id' => '3'],
            ['name' => 'B.Tech', 'remarks' => 'n/a', 'enabled' => 'yes', 'exam_level_id' => '3'],
            ['name' => 'BBA', 'remarks' => 'n/a', 'enabled' => 'yes', 'exam_level_id' => '3'],
            ['name' => 'BBS', 'remarks' => 'n/a', 'enabled' => 'yes', 'exam_level_id' => '3'],
            ['name' => 'BBS (Pass Course)', 'remarks' => 'n/a', 'enabled' => 'yes', 'exam_level_id' => '3'],
            ['name' => 'Fazil', 'remarks' => 'n/a', 'enabled' => 'yes', 'exam_level_id' => '3'],
            ['name' => 'L.L.B (Pass Course)', 'remarks' => 'n/a', 'enabled' => 'yes', 'exam_level_id' => '3'],
            ['name' => 'L.L.B. (Honours)', 'remarks' => 'n/a', 'enabled' => 'yes', 'exam_level_id' => '3'],
            ['name' => 'M.B.B.S/ B.D.S', 'remarks' => 'n/a', 'enabled' => 'yes', 'exam_level_id' => '3'],
            ['name' => 'Others', 'remarks' => 'n/a', 'enabled' => 'yes', 'exam_level_id' => '3'],
            ['name' => 'Kamil', 'remarks' => 'n/a', 'enabled' => 'yes', 'exam_level_id' => '4'],
            ['name' => 'LL.M', 'remarks' => 'n/a', 'enabled' => 'yes', 'exam_level_id' => '4'],
            ['name' => 'M.A', 'remarks' => 'n/a', 'enabled' => 'yes', 'exam_level_id' => '4'],
            ['name' => 'M.Com', 'remarks' => 'n/a', 'enabled' => 'yes', 'exam_level_id' => '4'],
            ['name' => 'M.Ed', 'remarks' => 'n/a', 'enabled' => 'yes', 'exam_level_id' => '4'],
            ['name' => 'M.S.S', 'remarks' => 'n/a', 'enabled' => 'yes', 'exam_level_id' => '4'],
            ['name' => 'M.Sc', 'remarks' => 'n/a', 'enabled' => 'yes', 'exam_level_id' => '4'],
            ['name' => 'M.Sc (Agricultural Science)', 'remarks' => 'n/a', 'enabled' => 'yes', 'exam_level_id' => '4'],
            ['name' => 'M.Sc (Engineering/Architecture)', 'remarks' => 'n/a', 'enabled' => 'yes', 'exam_level_id' => '4'],
            ['name' => 'MBA', 'remarks' => 'n/a', 'enabled' => 'yes', 'exam_level_id' => '4'],
            ['name' => 'MBS', 'remarks' => 'n/a', 'enabled' => 'yes', 'exam_level_id' => '4'],
            ['name' => 'ME/Mtech', 'remarks' => 'n/a', 'enabled' => 'yes', 'exam_level_id' => '4'],
            ['name' => 'Mmed', 'remarks' => 'n/a', 'enabled' => 'yes', 'exam_level_id' => '4'],
            ['name' => 'Others', 'remarks' => 'n/a', 'enabled' => 'yes', 'exam_level_id' => '4'],
            ['name' => 'Others', 'remarks' => 'n/a', 'enabled' => 'yes', 'exam_level_id' => '5'],

        ];

        foreach ($exam_titles as $exam_title):
            ExamTitle::create($exam_title);
        endforeach;
    }
}
