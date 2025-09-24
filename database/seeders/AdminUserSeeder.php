<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Zubair',
            'email' => 'zubaiirarshed@gmail.com',
            'password' => Hash::make('admin123'), // hashed password
            'role' => 'admin',
        ]);
    }
}
