<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Create 100 user
        for ($user = 0; $user < 20; $user++)
        {
            $created = User::create([
                'name' => $faker->name(),
                'email' => $faker->unique()->safeEmail,
                'password' => bcrypt('12345678')
            ]);

            $created->assignRole('user');
        }
    }
}
