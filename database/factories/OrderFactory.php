<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition()
    {
        return [
            // Define the fields that actually exist in the orders table
            'status' => $this->faker->randomElement(['in progress', 'On The Way', 'Delivered']),
            'user_id' => \App\Models\User::factory(), // Assuming orders are related to users
            'product_id' => \App\Models\Product::factory(), // Assuming orders are related to products
            'rec_address' => $this->faker->address,
            'phone' => $this->faker->phoneNumber,
            'name' => $this->faker->name,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}


