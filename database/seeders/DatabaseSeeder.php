<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ProductApplication;
use App\Models\ProductImage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create some sellers
        $sellers = User::factory()
        ->count(5)
        ->seller()
        ->create();

        // For each seller, create products + images
        $sellers->each(function ($seller) {
            $products = ProductApplication::factory()
                ->count(5)
                ->create([
                    'seller_id' => $seller->id,
                ]);
        });

        // Create one admin for login
        User::factory()->admin()->create([
            'email' => 'admin@example.com',
            'password' => bcrypt('admin123'),
        ]);
    }
}
