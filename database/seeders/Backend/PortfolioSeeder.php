<?php

namespace Database\Seeders\Backend;

use Database\Seeders\Backend\Portfolio\CertificateSeeder;
use Database\Seeders\Backend\Portfolio\ServiceSeeder;
use Exception;
use Illuminate\Database\Seeder;
use Throwable;

class PortfolioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws Exception|Throwable
     */
    public function run()
    {
        $this->call(ServiceSeeder::class);
        $this->call(CertificateSeeder::class);

    }

}
