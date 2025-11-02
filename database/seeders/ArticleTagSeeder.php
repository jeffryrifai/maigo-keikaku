<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ArticleTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = [
            'PDNS-1',
            'PDNS-2',
            'WAF',
            'VPN',
            'OKTA',
            'DNS/PTR Record',
            'Permohonan Resource',
            'Open Port',
            'Backup',
            'Load Balancer',
            'Kubernetes',
            'Openshift',
            'SOP',
            'Dokumentasi',
            'SPLP',
            'JIP',
        ];
        foreach ($tags as $tag) {
            DB::table('tm_article_tag')->insert([
                'nama_tag' => $tag,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
