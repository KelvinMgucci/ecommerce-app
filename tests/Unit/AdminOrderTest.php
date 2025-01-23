<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class AdminOrderTest extends TestCase
{
    use RefreshDatabase;

    // Test view_order
    public function test_view_order()
    {
        // Create an admin user with the 'usertype' set to 'admin'
        $adminUser = User::factory()->create(['usertype' => 'admin']);
        Auth::login($adminUser);

        // Create some orders
        Order::factory()->count(5)->create();

        // Visit the view_order route
        $response = $this->get(route('view_order'));

        // Check if the response contains data
        $response->assertStatus(200);
        $response->assertViewIs('admin.view_order');
        $response->assertViewHas('data');
    }

    // Test on_the_way
    public function test_on_the_way()
    {
        // Create an admin user with the 'usertype' set to 'admin'
        $adminUser = User::factory()->create(['usertype' => 'admin']);
        Auth::login($adminUser);

        // Create an order
        $order = Order::factory()->create();

        // Visit the on_the_way route
        $response = $this->get(route('on_the_way', ['id' => $order->id]));

        // Assert that the order status is updated to "On The Way"
        $order->refresh();
        $this->assertEquals('On The Way', $order->status);

        // Check for the redirection
        $response->assertRedirect(route('view_order'));
    }

    // Test delivered
    public function test_delivered()
    {
        // Create an admin user with the 'usertype' set to 'admin'
        $adminUser = User::factory()->create(['usertype' => 'admin']);
        Auth::login($adminUser);

        // Create an order
        $order = Order::factory()->create();

        // Visit the delivered route
        $response = $this->get(route('delivered', ['id' => $order->id]));

        // Assert that the order status is updated to "Delivered"
        $order->refresh();
        $this->assertEquals('Delivered', $order->status);

        // Check for the redirection
        $response->assertRedirect(route('view_order'));
    }
}


