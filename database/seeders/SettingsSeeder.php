<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('settings')->insert([
            ['key' => 'upload_file_size', 'value' => '5000'],
            ['key' => 'upload_file_format', 'value' => 'png | jpg | jpeg | pdf |'],
            ['key' => 'upload_file_path', 'value' => 'uploads'],


        ]);
    }
}
