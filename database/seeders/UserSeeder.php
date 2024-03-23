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
        for ($i = 1; $i <= 30; $i++) {
            User::create([
                'USER_ID' => 'USER' . sprintf('%03d', $i),
                'name' => 'ユーザー' . $i,
                'KAISYA_CODE' => 'COMP' . sprintf('%02d', ceil($i / 5)),
                'SOSHIKI_CODE' => 'ORG' . sprintf('%02d', ceil($i / 5)),
                'KENGEN_KUBUN' => rand(1, 2),
                'email' => 'user' . $i . '@example.com',
                'password' => bcrypt('password'),
            ]);
        }
    }
}
