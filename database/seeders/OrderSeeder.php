<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $customers = User::where('role', 'customer')->get();
        $products = Product::all();
        $statuses = ['pending', 'paid', 'shipped', 'delivered', 'canceled'];
        $payments = ['unpaid', 'paid', 'refunded'];
        $methods = ['stripe', 'paypal'];

        foreach ($customers->take(5) as $customer) {
            for ($i = 0; $i < rand(2, 3); $i++) {
                $orderItems = $products->random(rand(1, 4));
                $total = 0;
                foreach ($orderItems as $p) $total += $p->price * rand(1, 3);

                $order = Order::create([
                    'user_id' => $customer->id,
                    'total_amount' => $total,
                    'payment_status' => $payments[array_rand($payments)],
                    'order_status' => $statuses[array_rand($statuses)],
                    'shipping_address' => $customer->address,
                    'payment_method' => $methods[array_rand($methods)],
                    'created_at' => now()->subDays(rand(1, 30)),
                ]);

                foreach ($orderItems as $p) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $p->id,
                        'quantity' => rand(1, 3),
                        'price' => $p->price,
                    ]);
                }
            }
        }
    }
}
