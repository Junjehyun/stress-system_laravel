<?php

namespace Database\Factories;

use App\Models\Haisya_mst;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class Haisya_mstFactory extends Factory
{
    protected $model = Haisya_mst::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'KAISYA_CODE' => $this->faker->regexify('[A-Za-z0-9]{6}'),
            'KAISYA_NAME_JPN' => $this->faker->company,
            'KAISYA_NAME_ENG' => $this->faker->company,
        ];
    }
}
