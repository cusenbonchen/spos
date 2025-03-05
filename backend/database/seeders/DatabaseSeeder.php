<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Setting;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Tạo user admin
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('123123'),
        ]);

        // Tạo khách hàng
        Customer::factory(10)->create();

        // Tạo sản phẩm
        Product::factory(20)->create();

        // Tạo đơn hàng với mỗi đơn hàng có từ 1-5 sản phẩm
        Order::factory(15)->create()->each(function ($order) {
            $products = Product::inRandomOrder()->take(rand(1, 5))->get();
            foreach ($products as $product) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => rand(1, 3),
                    'price' => $product->price,
                    'subtotal' => rand(1, 10)
                ]);
            }
        });

        // Cấu hình hệ thống mặc định
        DB::table('settings')->insert([
            'key' => 'currency',
            'value' => 'VND',
        ]);
    }
}
