<?php

namespace Database\Seeders\Backend\Portfolio;

use App\Models\Backend\Portfolio\Testimonial;
use Database\Factories\Backend\Portfolio\TestimonialFactory;
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
        /**
         * @var TestimonialFactory
         */
        Testimonial::factory()->count(20)->create();
    }
}
