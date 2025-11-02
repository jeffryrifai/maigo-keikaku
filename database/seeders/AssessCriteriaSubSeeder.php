<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AssessCriteriaSubSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $criteria_sub =[
            [
                'id_criteria' => 1,
                'nama_sub_kriteria' => 'Surat resmi',
                'sub_type' => 'ada',
                'min_value' => 0,
                'max_value' => 1,
                'status' => 'open',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_criteria' => 1,
                'nama_sub_kriteria' => 'Tanda tangan',
                'sub_type' => 'ada',
                'min_value' => 0,
                'max_value' => 1,
                'status' => 'open',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_criteria' => 1,
                'nama_sub_kriteria' => 'Kop surat',
                'sub_type' => 'ada',
                'min_value' => 0,
                'max_value' => 1,
                'status' => 'open',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_criteria' => 1,
                'nama_sub_kriteria' => 'Tujuan surat',
                'sub_type' => 'benar',
                'min_value' => 0,
                'max_value' => 1,
                'status' => 'open',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_criteria' => 2,
                'nama_sub_kriteria' => 'Surat pernyataan open port',
                'sub_type' => 'ada',
                'min_value' => 0,
                'max_value' => 1,
                'status' => 'open',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_criteria' => 3,
                'nama_sub_kriteria' => 'Tenant migrasi',
                'sub_type' => 'termasuk',
                'min_value' => 0,
                'max_value' => 1,
                'status' => 'open',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_criteria' => 4,
                'nama_sub_kriteria' => 'Dokumen Urgensi dan Justifikasi Permintaan',
                'sub_type' => 'ada',
                'min_value' => 0,
                'max_value' => 1,
                'status' => 'open',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_criteria' => 4,
                'nama_sub_kriteria' => 'Timeline Pemanfaatan Resource',
                'sub_type' => 'ada',
                'min_value' => 0,
                'max_value' => 1,
                'status' => 'open',
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ];

        
        \DB::table('tm_assess_criteria_sub')
            ->insert($criteria_sub);
    }
}
