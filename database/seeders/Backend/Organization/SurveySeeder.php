<?php

namespace Database\Seeders\Backend\Organization;

use App\Models\Backend\Organization\Survey;
use Illuminate\Database\Seeder;

class SurveySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $surveys = array(
            array('id' => '1','name' => 'Household Income and Expenditure Survey (HIES) 2016','enabled' => 'yes'),
            array('id' => '2','name' => 'Health and Morbidity Status Survey (HMSS) 2014','enabled' => 'yes'),
            array('id' => '3','name' => 'Labour Force Survey (LFS) 2016-17','enabled' => 'yes'),
            array('id' => '4','name' => 'Multiple Indicator Cluster Survey (MICS) 2019','enabled' => 'yes'),
            array('id' => '5','name' => 'Survey of Manufacturing Indistries (SMI) 2019','enabled' => 'yes'),
            array('id' => '6','name' => 'Perception Survey on Livelihood (PSL), 2020','enabled' => 'yes'),
            array('id' => '7','name' => 'Cost of Migration Survey, 2019-20','enabled' => 'yes'),
            array('id' => '8','name' => 'Survey on the Use of Remittance 2013, 2016','enabled' => 'yes'),
            array('id' => '9','name' => 'Survey of Tourism Satellite Account 2013','enabled' => 'yes'),
            array('id' => '10','name' => 'Violence Against Women Survey, 2011, 2015','enabled' => 'yes'),
            array('id' => '11','name' => 'Time Use Survey 2012, 2021','enabled' => 'yes'),
            array('id' => '12','name' => 'Informal Sector Survey (ISS), 2010','enabled' => 'yes'),
            array('id' => '13','name' => 'Wholesale and Retail Trade Survey, 1992-93, 2002-03, 2009-10, 2020','enabled' => 'yes'),
            array('id' => '14','name' => 'Hotel and Restaurant Survey, 2009','enabled' => 'yes'),
            array('id' => '15','name' => 'Survey on Private Education Establishments, 2007-08','enabled' => 'yes'),
            array('id' => '16','name' => 'Survey on Private Health Service Establishment, 2007-08, 2020','enabled' => 'yes'),
            array('id' => '17','name' => 'User Satisfaction Survey 2022','enabled' => 'yes'),
            array('id' => '18','name' => 'Unde explicabo vitae voluptate necessitatibus. Nisi quis est aspernatur architecto ipsa omnis aut sit.','enabled' => 'no'),
            array('id' => '19','name' => 'Architecto perferendis autem nobis sed autem.','enabled' => 'no'),
            array('id' => '20','name' => 'Aut qui consequatur eaque eligendi ut quo qui. Et rerum similique praesentium est.','enabled' => 'no')
        );

        foreach ($surveys as $survey):
            Survey::create($survey);
        endforeach;
    }
}
