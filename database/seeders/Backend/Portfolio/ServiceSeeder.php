<?php

namespace Database\Seeders\Backend\Portfolio;

use App\Models\Backend\Portfolio\Service;
use Database\Factories\Backend\Portfolio\ServiceFactory;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * @var ServiceFactory
         */
        Service::factory()->count(20)->create();
    }
}
