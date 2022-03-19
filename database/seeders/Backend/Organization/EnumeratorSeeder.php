<?php

namespace Database\Seeders\Backend\Organization;

use App\Models\Backend\Organization\Enumerator;
use Illuminate\Database\Seeder;

class EnumeratorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Enumerator::factory()->count(20)->create();
    }
}
