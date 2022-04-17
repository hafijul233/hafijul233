<?php

namespace Database\Seeders\Backend\Setting;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws Exception
     */
    public function run()
    {
        Model::unguard();

        DB::beginTransaction();
        try {
            DB::disableQueryLog();
            DB::table('cities')->truncate();
            DB::unprepared(file_get_contents(__DIR__ . '/cities/019.sql'));
            DB::commit();
            DB::enableQueryLog();
        } catch (\PDOException $exception) {
            DB::rollBack();
            throw new \PDOException($exception->getMessage());
        }
    }
}