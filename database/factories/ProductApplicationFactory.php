<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductApplication>
 */
class ProductApplicationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'seller_id' => User::factory()->seller(), // will attach seller
            'title' => $this->faker->words(3, true),
            'description' => $this->faker->paragraph(),
            'price' => $this->faker->randomFloat(2, 10, 200),
            'sku' => strtoupper($this->faker->bothify('??###')),
            'barcode' => $this->faker->ean13(),
            'inventory' => $this->faker->numberBetween(5, 100),
            'status' => 'pending'
        ];
        
    }
}
