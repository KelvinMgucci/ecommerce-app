<?php

use Tests\TestCase;
// tests/Feature/CategoryTest.php

use App\Models\User;
use App\Models\Category;


class CategoryTest extends TestCase
{
    // Helper function to return an authenticated admin user
    protected function adminUser()
    {
        return User::factory()->admin()->create(); // This will create an admin user
    }

    public function test_view_category()
    {
        // Create a category
        $category = Category::factory()->create();

        // Act as an authenticated admin user
        $response = $this->actingAs($this->adminUser())
            ->get(route('view_category'));

        // Assert the response status and that the category is displayed in the view
        $response->assertStatus(200);
        $response->assertViewHas('data', function ($data) use ($category) {
            return $data->contains($category);
        });
    }

    public function test_add_category()
{
    // Act as an authenticated admin user
    $user = $this->adminUser(); // Create admin user
    $this->actingAs($user); // Log in as the admin user

    // Prepare category data
    $categoryData = [
        'category' => 'New Category',
    ];

    // Submit POST request to add the category
    $response = $this->post(route('add_category'), $categoryData);

    // Assert that the category was added to the database
    $this->assertDatabaseHas('categories', [
        'category_name' => 'New Category',
    ]);

    // Assert the user is redirected back with a success message in the session
    $response->assertRedirect()->assertSessionHas('success', 'Category added successfully'); // Check for the 'success' key
}


public function test_delete_category()
{
    // Act as an authenticated admin user
    $user = $this->adminUser(); // Create admin user
    $this->actingAs($user); // Log in as the admin user

    // Create a category to delete
    $category = Category::create([
        'category_name' => 'Category to delete',
    ]);

    // Assert that the category exists in the database
    $this->assertDatabaseHas('categories', [
        'category_name' => 'Category to delete',
    ]);

    // Send a DELETE request to the delete_category route
    $response = $this->delete(route('delete_category', $category->id));

    // If using soft deletes, check the 'deleted_at' field
    if (class_exists('Illuminate\Database\Eloquent\SoftDeletes') && in_array('Illuminate\Database\Eloquent\SoftDeletes', class_uses(Category::class))) {
        $this->assertDatabaseHas('categories', [
            'category_name' => 'Category to delete',
         
        ]);
    } else {
        // For hard deletes, assert the category is missing from the database
        $this->assertDatabaseMissing('categories', [
            'category_name' => 'Category to delete',
        ]);
    }

    // Assert that the user is redirected back with a success message
    $response->assertRedirect()->assertSessionHas('success', 'Category deleted successfully');
}
public function test_edit_category()
{
    // Step 1: Create an admin user and authenticate
    $user = $this->adminUser(); // Ensure this method returns an admin user
    $this->actingAs($user); // Act as the admin user for the test

    // Step 2: Create a category to edit
    $category = Category::create([
        'category_name' => 'Category to edit',
    ]);

    // Step 3: Send a POST request to the update category route
    $response = $this->post(route('update_category', $category->id), [
        'category' => 'Updated Category',
    ]);

    // Step 4: Assert that the category was updated in the database
    $this->assertDatabaseHas('categories', [
        'id' => $category->id,
        'category_name' => 'Updated Category',
    ]);

    // Step 5: Assert that the user is redirected back with a success message
    $response->assertRedirect(route('view_category')); // Redirect to view_category page
    $response->assertSessionHas('success', 'Category Updated successfully');
}


}

