<?php

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

uses(RefreshDatabase::class);

// it('can create a product', function () {
//     $response = $this->post('/products', [
//         'name' => 'Sample Product',
//         'description' => 'This is a sample product.',
//         'price' => 99.99,
//         'quantity' => 10,
//         'image' => 'images/tGLIjwFFeFBUqzXkwCmo1GguCBU8pTFhw9Yhz6uc.jpg'
//     ]);

//     $response->assertStatus(302); // Redirect after successful creation
//     // $this->assertDatabaseHas('products', ['name' => 'Sample Product']);
// });


it('can create a product', function () {
    Storage::fake('public');

    $response = $this->post('/products', [
        'name' => 'Sample Product',
        'description' => 'This is a sample product.',
        'price' => 99.99,
        'quantity' => 10,
        'image' => UploadedFile::fake()->image('product.jpg')
    ]);

    $response->assertStatus(302); // Redirect after successful creation

    // Fetch the product from the database
    $product = Product::where('name', 'Sample Product')->first();

    // Verify other attributes
    $this->assertNotNull($product);
    $this->assertEquals('Sample Product', $product->name);
    $this->assertEquals('This is a sample product.', $product->description);
    $this->assertEquals(99.99, $product->price);
    $this->assertEquals(10, $product->quantity);

    // Check if the image path starts with 'images/'
    $this->assertStringStartsWith('images/', $product->image);
});

it('can update a product', function () {
    $product = Product::factory()->create();

    $response = $this->put("/products/{$product->id}", [
        'name' => 'Updated Product',
        'description' => 'This is an updated product.',
        'price' => 89.99,
        'quantity' => 20,
    ]);

    $response->assertStatus(302); // Redirect after successful update
    $this->assertDatabaseHas('products', ['name' => 'Updated Product']);
});

it('can delete a product', function () {
    $product = Product::factory()->create();

    $response = $this->delete("/products/{$product->id}");

    $response->assertStatus(302); // Redirect after successful deletion
    $this->assertDatabaseMissing('products', ['id' => $product->id]);
});
