<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use League\Csv\Reader; 
use Illuminate\Support\Facades\File;

class AssessResourceLegacySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // kalau datanya dari file JSON
        $json = File::get(database_path('seeders/data/legacy.json'));
        $data = json_decode($json, true); // ubah ke array associative

        // tambahkan timestamp biar gak null
        $now = now();
        foreach ($data as &$item) {
            $item['created_at'] = $now;
            $item['updated_at'] = $now;
        }

        \DB::table('tr_assess_resource_legacy')->insert($data);
    }
}
