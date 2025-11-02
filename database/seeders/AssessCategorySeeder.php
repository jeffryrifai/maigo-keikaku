<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AssessCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['nama_kategori' => 'Permohonan Resource', 'jenis' => 'resource', 'created_at' => now(), 'updated_at' => now()],
            ['nama_kategori' => 'Permohonan Open Port', 'jenis' => 'open_port', 'created_at' => now(), 'updated_at' => now()],
            ['nama_kategori' => 'VPN dan OKTA', 'jenis' => 'general', 'created_at' => now(), 'updated_at' => now()],
            ['nama_kategori' => 'PTR', 'jenis' => 'general', 'created_at' => now(), 'updated_at' => now()],
            ['nama_kategori' => 'Permohonan Backup', 'jenis' => 'general', 'created_at' => now(), 'updated_at' => now()],
            ['nama_kategori' => 'Permohonan Restore Data', 'jenis' => 'general', 'created_at' => now(), 'updated_at' => now()],
            ['nama_kategori' => 'Permohonan SSL', 'jenis' => 'general', 'created_at' => now(), 'updated_at' => now()],
            ['nama_kategori' => 'Permohonan WAF', 'jenis' => 'general', 'created_at' => now(), 'updated_at' => now()],
            ['nama_kategori' => 'Permohonan EDR', 'jenis' => 'general', 'created_at' => now(), 'updated_at' => now()],
            ['nama_kategori' => 'Colocation', 'jenis' => 'general', 'created_at' => now(), 'updated_at' => now()],
            ['nama_kategori' => 'Layanan Pendukung', 'jenis' => 'general', 'created_at' => now(), 'updated_at' => now()],
            ['nama_kategori' => 'Migrasi', 'jenis' => 'migrasi', 'created_at' => now(), 'updated_at' => now()],
            ['nama_kategori' => 'Lain-lain', 'jenis' => 'general', 'created_at' => now(), 'updated_at' => now()],
        ];


        
        \DB::table('tm_assess_category')->insert($categories);
        


    }
}
