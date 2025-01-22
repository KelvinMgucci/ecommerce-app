<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Create an admin user for authentication.
     */

     protected function adminUser()
     {
         return User::factory()->admin()->create(); // This will create an admin user
     }
 
    /**
     * Test adding a product.
     */
   // Example Test
  
   
   
   public function testAddProduct()
   {
       // Create a temporary file to mock the image
       $file = \Illuminate\Http\Testing\File::image('dummy.jpg', 100, 100);
   
       // Send the POST request to add the product
       $response = $this->actingAs($this->adminUser())  // Ensure you are logged in as an admin
           ->post(route('upload_product'), [
               'title' => 'Sample Product',
               'description' => 'Sample description',
               'price' => 100,
               'quantity' => 10,
               'category' => 1, // Assuming category ID is 1
               'image' => $file,
           ]);
   
       // Check if the response redirects
       $response->assertRedirect();
   
       // Check for the session flash message
       $response->assertSessionHas('success', 'Product Added successfully');
   }
   
   
   
    /**
     * Test viewing all products.
     */
    public function test_view_products()
    {
        $admin = $this->adminUser();
        $this->actingAs($admin);

        Product::factory()->count(3)->create();

        $response = $this->get(route('view_product'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.view_product');
        $response->assertViewHas('product');
    }

    /**
     * Test deleting a product.
     */
    public function testDeleteProduct()
    {
        // Create a product to delete
        $product = Product::factory()->create();
    
        // Send a DELETE request to delete the product
        $response = $this->actingAs($this->adminUser())  // Ensure you're logged in as an admin
            ->delete(route('delete_product', $product->id));  // Use DELETE method, or use GET if it's a link
    
        // Check if the response redirects
        $response->assertRedirect();
    
        // Check for the success flash message in the session 
        $response->assertSessionHas('success', 'Product Deleted successfully');
    
        // Check if the product has been deleted from the database
        $this->assertDatabaseMissing('products', [
            'id' => $product->id,
        ]);
    }
    
    
    /**
     * Test updating a product.
     */
    public function test_update_product()
    {
        $admin = $this->adminUser();
        $this->actingAs($admin);

        $product = Product::factory()->create([
            'title' => 'Old Product',
            'description' => 'Old description',
        ]);

        $category = Category::create(['category_name' => 'Updated Category']);

        $response = $this->post(route('edit_product', $product->id), [
            'title' => 'Updated Product',
            'description' => 'Updated description',
            'price' => 120.99,
            'quantity' => 5,
            'category' => $category->id,
        ]);

        $response->assertRedirect('/view_product');
        $response->assertSessionHas('success', 'Product Updated successfully');

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'title' => 'Updated Product',
            'description' => 'Updated description',
            'price' => 120.99,
            'quantity' => 5,
            'category' => $category->id,
        ]);
    }

    /**
     * Test searching for a product.
     */
    public function test_search_product()
    {
        $admin = $this->adminUser();
        $this->actingAs($admin);

        Product::factory()->create([
            'title' => 'Unique Product',
        ]);

        $response = $this->get(route('product_search', ['search' => 'Unique']));

        $response->assertStatus(200);
        $response->assertViewIs('admin.view_product');
        $response->assertViewHas('product');

        $this->assertTrue($response->viewData('product')->contains('title', 'Unique Product'));
    }
}
