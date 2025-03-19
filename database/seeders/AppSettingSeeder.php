<?php

namespace Database\Seeders;

use App\Models\AppSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AppSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AppSetting::insert([
            ['key' => 'delivery_charge_below_50', 'value' => '4.95'],
            ['key' => 'delivery_charge_below_90', 'value' => '2.95'],
            ['key' => 'delivery_charge_free_threshold', 'value' => '90'],
        ]);
    }
}
