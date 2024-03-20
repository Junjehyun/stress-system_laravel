<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        //User::factory()->count(10)->create();
        for ($i = 1; $i <= 10; $i++) {
            User::create([
                'USER_ID' => 'USER' . sprintf('%03d', $i),
                'name' => '사용자' . $i,
                'KAISYA_CODE' => 'COMP' . sprintf('%02d', $i),
                'SOSHIKI_CODE' => 'ORG' . sprintf('%02d', $i),
                'email' => 'user' . $i . '@example.com',
                'password' => bcrypt('password'),
            ]);
        }
    }
}
