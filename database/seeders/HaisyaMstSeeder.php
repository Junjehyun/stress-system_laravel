<?php

namespace Database\Seeders;
use App\Models\Haisya_mst;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HaisyaMstSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 10; $i++) {
            Haisya_mst::create([
                'KAISYA_CODE' => 'COMP' . sprintf('%02d', $i),
                'KAISYA_NAME_JPN' => '会社名' . $i,
                'KAISYA_NAME_ENG' => 'Company' . $i,
            ]);
        }
    }
}
