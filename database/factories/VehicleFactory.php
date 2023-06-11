<?php

namespace Database\Factories;

use App\Models\Type;
use App\Models\Usecase;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vehicle>
 */
class VehicleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->sentence(3),
            'description' => fake()->paragraph(),
            'short_description' => fake()->sentence(),
            'price' => rand(95, 220),
            'range' => rand(60, 120),
            'contract_duration' => array_rand(array_flip([12,24,36,48,60])),
            'drivers_license' => rand(0, 1),
            'motorway' => rand(0, 1),
            'top_box' => rand(0, 1),
            'usecase_id' => Usecase::inRandomOrder()->first()->id,
            'type_id' => Type::inRandomOrder()->first()->id
        ];
    }
}
