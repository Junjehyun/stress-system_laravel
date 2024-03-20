<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Taisyo_soshiki;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class Taisyo_soshikiFactory extends Factory
{
    protected $model = Taisyo_soshiki::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'KAISYA_CODE' => $this->faker->regexify('[A-Z0-9]{6}'),
            'SOSHIKI_CODE' => $this->faker->regexify('[A-Z0-9]{69}'),
            'KAISYA_NAME_JPN' => $this->faker->lexify('??????????'),
            'SOSHIKI_NAME_JPN' => $this->faker->lexify('??????????'),
        ];
    }
}
