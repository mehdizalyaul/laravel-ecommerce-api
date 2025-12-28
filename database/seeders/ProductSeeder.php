<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            ['Wireless Bluetooth Headphones', 'Premium noise-cancelling wireless headphones.', 199.99, 50],
            ['Smart Watch Pro', 'Fitness tracking smartwatch with GPS.', 299.99, 35],
            ['Laptop Stand Aluminum', 'Adjustable ergonomic stand.', 49.99, 100],
            ['Mechanical Gaming Keyboard', 'RGB backlit mechanical keyboard.', 149.99, 45],
            ['Wireless Mouse', 'Ergonomic mouse with precision tracking.', 39.99, 80],
            ['Air Fryer XL', 'Large capacity air fryer.', 129.99, 25],
            ['Leather Backpack', 'Genuine leather backpack.', 149.99, 30],
            ['Yoga Mat Premium', 'Eco-friendly yoga mat.', 39.99, 75],
            ['E-Reader 8-inch', 'High-resolution e-reader.', 139.99, 40],
            ['Wireless Charging Pad', 'Fast Qi wireless charger.', 24.99, 95],
        ];

        foreach ($products as [$title, $description, $price, $stock]) {
            Product::create([
                'title' => $title,
                'description' => $description,
                'price' => $price,
                'stock' => $stock,
            ]);
        }

        // Product::factory()->count(20)->create();
    }
}
