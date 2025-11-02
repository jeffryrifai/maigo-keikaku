<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AssessCriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $criteria = [
            [
                'nama_kriteria' => 'Kelengkapan Administrasi',
                'tipe_kriteria' => 'checklist',
                'bobot' => 30,
                'jenis' => 'required',
                'status' => 'open',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_kriteria' => 'Surat Open Port',
                'tipe_kriteria' => 'checklist',
                'bobot' => 80,
                'jenis' => 'open_port',
                'status' => 'open',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_kriteria' => 'Termasuk Tenant Migrasi',
                'tipe_kriteria' => 'checklist',
                'bobot' => 100,
                'jenis' => 'migrasi',
                'status' => 'open',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_kriteria' => 'Kelengkapan Dokumen Permintaan Resource',
                'tipe_kriteria' => 'checklist',
                'bobot' => 50,
                'jenis' => 'resource',
                'status' => 'open',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_kriteria' => 'Permintaan Resource',
                'tipe_kriteria' => 'resource',
                'bobot' => 0,
                'jenis' => 'resource',
                'status' => 'open',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_kriteria' => 'Hasil Assessment',
                'tipe_kriteria' => 'resource',
                'bobot' => 0,
                'jenis' => 'resource',
                'status' => 'open',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_kriteria' => 'Urgensi Layanan',
                'tipe_kriteria' => 'level',
                'bobot' => 20,
                'jenis' => 'required',
                'status' => 'open',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_kriteria' => 'Dampak Terhadap Operasional',
                'tipe_kriteria' => 'level',
                'bobot' => 50,
                'jenis' => 'required',
                'status' => 'open',
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ];

        
        \DB::table('tm_assess_criteria')
            ->insert($criteria);
    }
}
