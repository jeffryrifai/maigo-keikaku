<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Jeffry',
            'username' => 'jeffrydev',
            'password' => 'J3ffry!2345',
        ]);

        User::factory()->create([
            'name' => 'Cepi',
            'username' => 'cepi001',
            'password' => 's1p4kb3s%$#@!',
        ]);
        User::factory()->create([
            'name' => 'Nayaka',
            'username' => 'naya002',
            'password' => 's1p4kb3s%$#@!',
        ]);
        User::factory()->create([
            'name' => 'Taufiq',
            'username' => 'tauf025',
            'password' => 's1p4kb3s%$#@!',
        ]);
        User::factory()->create([
            'name' => 'Arie',
            'username' => 'arie033',
            'password' => 's1p4kb3s%$#@!',
        ]);
        User::factory()->create([
            'name' => 'Putra',
            'username' => 'baid001',
            'password' => 's1p4kb3s%$#@!',
        ]);
        User::factory()->create([
            'name' => 'Ronald',
            'username' => 'rona006',
            'password' => 's1p4kb3s%$#@!',
        ]);        

        $this->call([
            ArticleTagSeeder::class,
            TenantSeeder::class,
            AssessCategorySeeder::class,
            AssessCriteriaSeeder::class,
            AssessCriteriaSubSeeder::class,
            AssessResourceLegacySeeder::class
        ]);
    }
}
