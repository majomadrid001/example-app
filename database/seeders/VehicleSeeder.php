<?php

namespace Database\Seeders;

use App\Models\Vehicle;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VehicleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Vehicle::factory()
            ->count(300)
            ->hasReviews(3)
            ->hasTypes(1)
            ->hasUsecases(1)
            ->hasImages(5)
            ->create();
    }
}
