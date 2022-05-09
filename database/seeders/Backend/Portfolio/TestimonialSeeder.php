<?php

namespace Database\Seeders\Backend\Portfolio;

use App\Models\Backend\Portfolio\Service;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Service::factory()->count(20)->create();
    }
}
