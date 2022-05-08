<?php

namespace Database\Seeders\Backend\Portfolio;

use App\Models\Backend\Portfolio\Certificate;
use App\Models\Backend\Portfolio\Service;
use Illuminate\Database\Seeder;

class CertificateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Certificate::factory()->count(20)->create();
    }
}
