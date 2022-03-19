<?php

namespace Database\Seeders\Backend\Setting;

use App\Models\Backend\Setting\Catalog;
use App\Supports\Constant;
use Illuminate\Database\Seeder;

class BoardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $boards = [
            ['type' => Constant::CATALOG_TYPE['BOARD'], 'name' => 'Dhaka Board', 'remarks' => 'Education board name', 'additional_info' => [], 'enabled' => Constant::ENABLED_OPTION],
            ['type' => Constant::CATALOG_TYPE['BOARD'], 'name' => 'Cumilla Board', 'remarks' => 'Education board name', 'additional_info' => [], 'enabled' => Constant::ENABLED_OPTION],
            ['type' => Constant::CATALOG_TYPE['BOARD'], 'name' => 'Rajshahi Board', 'remarks' => 'Education board name', 'additional_info' => [], 'enabled' => Constant::ENABLED_OPTION],
            ['type' => Constant::CATALOG_TYPE['BOARD'], 'name' => 'Jashore Board', 'remarks' => 'Education board name', 'additional_info' => [], 'enabled' => Constant::ENABLED_OPTION],
            ['type' => Constant::CATALOG_TYPE['BOARD'], 'name' => 'Chittagong Board', 'remarks' => 'Education board name', 'additional_info' => [], 'enabled' => Constant::ENABLED_OPTION],
            ['type' => Constant::CATALOG_TYPE['BOARD'], 'name' => 'Barishal Board', 'remarks' => 'Education board name', 'additional_info' => [], 'enabled' => Constant::ENABLED_OPTION],
            ['type' => Constant::CATALOG_TYPE['BOARD'], 'name' => 'Sylhet Board', 'remarks' => 'Education board name', 'additional_info' => [], 'enabled' => Constant::ENABLED_OPTION],
            ['type' => Constant::CATALOG_TYPE['BOARD'], 'name' => 'Dinajpur Board', 'remarks' => 'Education board name', 'additional_info' => [], 'enabled' => Constant::ENABLED_OPTION],
            ['type' => Constant::CATALOG_TYPE['BOARD'], 'name' => 'Mymensingh Board', 'remarks' => 'Education board name', 'additional_info' => [], 'enabled' => Constant::ENABLED_OPTION],
            ['type' => Constant::CATALOG_TYPE['BOARD'], 'name' => 'Madrasah Board', 'remarks' => 'Education board name', 'additional_info' => [], 'enabled' => Constant::ENABLED_OPTION],
            ['type' => Constant::CATALOG_TYPE['BOARD'], 'name' => 'Technical Board', 'remarks' => 'Education board name', 'additional_info' => [], 'enabled' => Constant::ENABLED_OPTION],
            ['type' => Constant::CATALOG_TYPE['BOARD'], 'name' => 'Cambridge International - IGCE', 'remarks' => 'Education board name', 'additional_info' => [], 'enabled' => Constant::ENABLED_OPTION],
            ['type' => Constant::CATALOG_TYPE['BOARD'], 'name' => 'Edexcel International', 'remarks' => 'Education board name', 'additional_info' => [], 'enabled' => Constant::ENABLED_OPTION],
            ['type' => Constant::CATALOG_TYPE['BOARD'], 'name' => 'Bangladesh Technical Education Board (BTEB)', 'remarks' => 'Education board name', 'additional_info' => [], 'enabled' => Constant::ENABLED_OPTION],
            ['type' => Constant::CATALOG_TYPE['BOARD'], 'name' => 'Others', 'remarks' => 'Education board name', 'additional_info' => [], 'enabled' => Constant::ENABLED_OPTION]
        ];

        foreach ($boards as $board):
            Catalog::create($board);
        endforeach;
    }
}
