<?php

namespace Database\Seeders\Backend\Portfolio;

use App\Models\Backend\Portfolio\Service;
use App\Models\Backend\Portfolio\Testimonial;
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
        Testimonial::factory()->count(20)->create();
    }
}
