<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $admin = User::create([
            "name" => "Administrator Tata Usaha",
            "password" => bcrypt('12345678'),
            "email" => "admin@gmail.com",
            "position" => "Adminstrator TU"
        ]);

        $admin->assignRole('admin');
    }
}
