<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductImageLinkTest extends TestCase
{
    use RefreshDatabase;

    public function test_product_image_links_to_its_detail_page(): void
    {
        $product = Product::create([
            'name' => 'Buket Test',
            'category' => 'bunga',
            'price' => 100000,
            'stock' => 5,
            'status' => 'Ready',
            'image' => 'products/buket-test.jpg',
            'description' => 'Deskripsi khusus halaman detail.',
        ]);

        $this->get(route('home'))
            ->assertOk()
            ->assertSee('Buket Test')
            ->assertDontSee('Deskripsi khusus halaman detail.')
            ->assertSeeInOrder([
                'href="'.route('products.show', $product).'"',
                '<img src="'.asset('storage/products/buket-test.jpg').'" alt="Buket Test"',
            ], false);

        $this->get(route('products.show', $product))
            ->assertOk()
            ->assertSee('Deskripsi khusus halaman detail.');
    }
}
