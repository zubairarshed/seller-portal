<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Product;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductImage>
 */
class ProductImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_id' => Product::factory(),
            // Using placeholder image for now
            'image_path' => function () 
            {
                $filename = $this->faker->image(
                storage_path('app/public/products'), // where images are stored
                400,                                 // width
                400,                                 // height
                'fashion',                           // category, e.g. 'fashion', 'cats', 'people'
                false                                // return filename only (e.g. "abc123.jpg")
            );

                // if faker failed, just fallback to placeholder
                return $filename ?: 'placeholder.jpg';
            },
            'is_main' => $this->faker->boolean(30)
        ];
    }
}
