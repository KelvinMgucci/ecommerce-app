<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use App\Models\Cart;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class CartTest extends TestCase
{
    use RefreshDatabase;

    
   /** @test */
   public function user_can_add_product_to_cart()
   {
       // Step 1: Create a user
       $user = User::factory()->create();
       
       // Step 2: Create a product
       $product = Product::factory()->create();
   
       // Step 3: Act as the user and add product to the cart
       $response = $this->actingAs($user)->get(route('add_cart', ['id' => $product->id]));
   
       // Step 4: Assert that the cart now contains the product
       $this->assertDatabaseHas('carts', [
           'user_id' => $user->id,
           'product_id' => $product->id
       ]);
   
       // Step 5: Assert that the user is redirected back and success message is shown
       $response->assertRedirect();
       $response->assertSessionHas('success', 'Product Added To Cart successfully');
   }


    /** @test */
    public function adding_product_to_cart_when_not_authenticated()
    {
        // Step 1: Create a product
        $product = Product::factory()->create();

        // Step 2: Try adding the product to the cart without authentication
        $response = $this->get(route('add_cart', ['id' => $product->id]));

        // Step 3: Assert that the user is redirected to the login page
        $response->assertRedirect(route('login'));
    }

    /** @test */
public function user_can_delete_product_from_cart()
{
    // Step 1: Create a user
    $user = User::factory()->create();
    
    // Step 2: Create a product
    $product = Product::factory()->create();

    // Step 3: Add product to the cart for this user
    $cart = Cart::create([
        'user_id' => $user->id,
        'product_id' => $product->id
    ]);

    // Step 4: Act as the user and delete the product from the cart
    $response = $this->actingAs($user)->get(route('delete_cart', ['id' => $cart->id]));

    // Step 5: Assert that the cart item is deleted
    $this->assertDatabaseMissing('carts', [
        'id' => $cart->id,
        'product_id' => $product->id,
        'user_id' => $user->id
    ]);

    // Step 6: Assert that the user is redirected back and success message is shown
    $response->assertRedirect();
    $response->assertSessionHas('success', 'Item Removed to cart');
}

}
