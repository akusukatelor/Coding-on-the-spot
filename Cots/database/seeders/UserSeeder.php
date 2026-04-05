<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::create([
        'name' => 'Alfin Ilham',
        'email' => 'sihemat@gmail.com',
        'password' => bcrypt('password123'), // Passwordnya ini ya
    ]);
    }
}
