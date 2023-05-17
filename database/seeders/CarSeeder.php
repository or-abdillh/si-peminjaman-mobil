<?php

namespace Database\Seeders;

use App\Models\Car;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class CarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

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
        
        foreach($cars as $car)
        {
            Car::create([
                'name' => $car,
                'status' => $faker->boolean()
            ]);
        }
    }
}
