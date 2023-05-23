<?php

namespace Database\Seeders;

use App\Models\Car;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // create 10 car
        $cars = [
            'Toyota Avanza',
            'Honda Jazz',
            'Suzuki Ertiga',
            'Mitsubishi Xpander',
            'Daihatsu Terios',
            'Nissan Livina',
            'Isuzu Panther',
            'Mazda CX-5',
            'Hyundai Creta',
            'Kia Seltos'
        ];

        foreach ($cars as $car) {
            Car::create([
                'name' => $car,
                'status' => false
            ]);
        }
    }
}
