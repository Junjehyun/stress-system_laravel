<?php

namespace Database\Seeders;
use App\Models\Taisyo_soshiki;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TaisyoSoshikiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        //aisyo_soshiki::factory()->count(10)->create();
        for ($i = 1; $i <= 10; $i++) {
            Taisyo_soshiki::create([
                'SOSHIKI_CODE' => 'ORG' . sprintf('%02d', $i),
                'KAISYA_CODE' => 'COMP' . sprintf('%02d', $i),
                'KAISYA_NAME_JPN' => '회사명' . $i,
                'SOSHIKI_NAME_JPN' => '조직명' . $i,
            ]);
        }
    }
}
