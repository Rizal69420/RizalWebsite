<?php

namespace Tests\Feature;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_root_url_immediately_redirects_to_login_for_guests(): void
    {
        $response = $this->get('/');
        $response->assertRedirect(route('login'));
    }

    public function test_guests_cannot_access_admin_routes(): void
    {
        $response = $this->get(route('admin.products.index'));
        $response->assertRedirect(route('login'));
    }

    public function test_regular_users_cannot_access_admin_routes(): void
    {
        $user = User::factory()->create(['role' => 'customer']);

        $response = $this->actingAs($user)->get(route('admin.products.index'));
        $response->assertForbidden();
    }

    public function test_admin_can_view_all_management_tables(): void
    {
        $admin = User::factory()->admin()->create();

        // Products table
        $response = $this->actingAs($admin)->get(route('admin.products.index'));
        $response->assertOk();
        $response->assertSee('Daftar Produk');

        // Categories table
        $response = $this->actingAs($admin)->get(route('admin.categories.index'));
        $response->assertOk();
        $response->assertSee('Daftar Kategori');

        // Brands table
        $response = $this->actingAs($admin)->get(route('admin.brands.index'));
        $response->assertOk();
        $response->assertSee('Daftar Brand');

        // Orders table
        $response = $this->actingAs($admin)->get(route('admin.orders.index'));
        $response->assertOk();
        $response->assertSee('Daftar Pesanan');

        // Users / Manager table
        $response = $this->actingAs($admin)->get(route('admin.users.index'));
        $response->assertOk();
        $response->assertSee('Daftar Manager');
    }

    public function test_stock_system_shows_out_of_stock_when_zero(): void
    {
        $admin = User::factory()->admin()->create();
        $category = Category::create(['name' => 'Monitors']);
        $brand = Brand::create(['name' => 'LG']);

        // Out of stock product
        $outOfStock = Product::create([
            'category_id' => $category->id,
            'brand_id' => $brand->id,
            'name' => 'LG UltraGear 27"',
            'price' => 4500000,
            'stock' => 0,
        ]);

        $response = $this->actingAs($admin)->get(route('admin.products.index'));
        $response->assertOk();
        $response->assertSee('Stok Habis (Out of Stock)');

        // Customer cannot add out of stock product to cart
        $customer = User::factory()->create(['role' => 'customer']);
        $cartResponse = $this->actingAs($customer)->post(route('cart.store'), [
            'product_id' => $outOfStock->id,
            'quantity' => 1,
        ]);
        $cartResponse->assertSessionHas('error');
    }

    public function test_admin_can_create_update_and_delete_category(): void
    {
        $admin = User::factory()->admin()->create();

        // Create
        $response = $this->actingAs($admin)->post(route('admin.categories.store'), [
            'name' => 'Graphics Cards',
            'description' => 'Dedicated video and display cards.',
        ]);
        $response->assertRedirect(route('admin.categories.index'));
        $this->assertDatabaseHas('categories', ['name' => 'Graphics Cards']);

        $category = Category::where('name', 'Graphics Cards')->first();

        // Edit page
        $editResponse = $this->actingAs($admin)->get(route('admin.categories.edit', $category));
        $editResponse->assertOk();
        $editResponse->assertSee('Graphics Cards');

        // Update
        $updateResponse = $this->actingAs($admin)->put(route('admin.categories.update', $category), [
            'name' => 'GPU & Graphics',
            'description' => 'Updated GPU category description.',
        ]);
        $updateResponse->assertRedirect(route('admin.categories.index'));
        $this->assertDatabaseHas('categories', ['name' => 'GPU & Graphics']);

        // Delete
        $deleteResponse = $this->actingAs($admin)->delete(route('admin.categories.destroy', $category));
        $deleteResponse->assertRedirect(route('admin.categories.index'));
        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }

    public function test_admin_can_create_and_manage_brand(): void
    {
        $admin = User::factory()->admin()->create();

        // Create Brand
        $response = $this->actingAs($admin)->post(route('admin.brands.store'), [
            'name' => 'ASUS ROG',
        ]);
        $response->assertRedirect(route('admin.brands.index'));
        $this->assertDatabaseHas('brands', ['name' => 'ASUS ROG', 'slug' => 'asus-rog']);

        $brand = Brand::where('name', 'ASUS ROG')->first();

        // Edit page
        $editResponse = $this->actingAs($admin)->get(route('admin.brands.edit', $brand));
        $editResponse->assertOk();
        $editResponse->assertSee('ASUS ROG');

        // Update
        $updateResponse = $this->actingAs($admin)->put(route('admin.brands.update', $brand), [
            'name' => 'ASUS Republic of Gamers',
        ]);
        $updateResponse->assertRedirect(route('admin.brands.index'));
        $this->assertDatabaseHas('brands', ['name' => 'ASUS Republic of Gamers']);

        // Delete
        $deleteResponse = $this->actingAs($admin)->delete(route('admin.brands.destroy', $brand));
        $deleteResponse->assertRedirect(route('admin.brands.index'));
        $this->assertDatabaseMissing('brands', ['id' => $brand->id]);
    }

    public function test_admin_can_create_and_manage_product(): void
    {
        $admin = User::factory()->admin()->create();
        $category = Category::create(['name' => 'Memory (RAM)', 'description' => 'Fast DDR4 and DDR5 RAM kits']);
        $brand = Brand::create(['name' => 'Corsair', 'slug' => 'corsair']);

        // Create Product
        $response = $this->actingAs($admin)->post(route('admin.products.store'), [
            'name' => 'Corsair Vengeance RGB 32GB',
            'category_id' => $category->id,
            'brand_id' => $brand->id,
            'description' => 'High speed 6000MHz memory kit.',
            'specifications' => '32GB (2x16GB) DDR5 6000MHz CL30',
            'price' => 1850000,
            'stock' => 15,
        ]);
        $response->assertRedirect(route('admin.products.index'));
        $this->assertDatabaseHas('products', ['name' => 'Corsair Vengeance RGB 32GB']);

        $product = Product::where('name', 'Corsair Vengeance RGB 32GB')->first();

        // Edit page
        $editResponse = $this->actingAs($admin)->get(route('admin.products.edit', $product));
        $editResponse->assertOk();
        $editResponse->assertSee('Corsair Vengeance RGB 32GB');

        // Update
        $updateResponse = $this->actingAs($admin)->put(route('admin.products.update', $product), [
            'name' => 'Corsair Vengeance RGB 32GB White',
            'category_id' => $category->id,
            'brand_id' => $brand->id,
            'price' => 1900000,
            'stock' => 20,
        ]);
        $updateResponse->assertRedirect(route('admin.products.index'));
        $this->assertDatabaseHas('products', ['name' => 'Corsair Vengeance RGB 32GB White']);

        // Delete
        $deleteResponse = $this->actingAs($admin)->delete(route('admin.products.destroy', $product));
        $deleteResponse->assertRedirect(route('admin.products.index'));
        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }

    public function test_admin_can_view_orders_and_update_status(): void
    {
        $admin = User::factory()->admin()->create();
        $customer = User::factory()->create();

        $order = Order::create([
            'user_id' => $customer->id,
            'total_price' => 2500000,
            'status' => 'pending',
        ]);

        $response = $this->actingAs($admin)->get(route('admin.orders.index'));
        $response->assertOk();
        $response->assertSee(number_format(2500000, 0, ',', '.'));

        $showResponse = $this->actingAs($admin)->get(route('admin.orders.show', $order));
        $showResponse->assertOk();

        // Update status
        $updateResponse = $this->actingAs($admin)->patch(route('admin.orders.updateStatus', $order), [
            'status' => 'completed',
        ]);
        $updateResponse->assertRedirect(route('admin.orders.show', $order));
        $this->assertDatabaseHas('orders', ['id' => $order->id, 'status' => 'completed']);
    }

    public function test_customer_can_use_cart_and_checkout(): void
    {
        $customer = User::factory()->create(['role' => 'customer']);
        $category = Category::create(['name' => 'Storage', 'description' => 'Fast NVMe SSDs']);
        $brand = Brand::create(['name' => 'Samsung', 'slug' => 'samsung']);

        $product = Product::create([
            'category_id' => $category->id,
            'brand_id' => $brand->id,
            'name' => 'Samsung 990 Pro 2TB',
            'price' => 2400000,
            'stock' => 10,
        ]);

        // Add to cart
        $cartResponse = $this->actingAs($customer)->post(route('cart.store'), [
            'product_id' => $product->id,
            'quantity' => 2,
        ]);
        $cartResponse->assertRedirect(route('cart.index'));
        $this->assertDatabaseHas('cart_items', [
            'product_id' => $product->id,
            'quantity' => 2,
        ]);

        // View Cart
        $viewCart = $this->actingAs($customer)->get(route('cart.index'));
        $viewCart->assertOk();
        $viewCart->assertSee('Samsung 990 Pro 2TB');

        // Checkout
        $checkoutResponse = $this->actingAs($customer)->post(route('orders.store'));
        $this->assertDatabaseHas('orders', [
            'user_id' => $customer->id,
            'total_price' => 4800000,
            'status' => 'pending',
        ]);

        // Stock should be deducted: 10 - 2 = 8
        $this->assertEquals(8, $product->fresh()->stock);

        // Cart items should be cleared
        $this->assertDatabaseMissing('cart_items', [
            'product_id' => $product->id,
        ]);
    }

    /**
     * Test that user sees product catalog on dashboard and shop, and out-of-stock products cannot be added to cart.
     */
    public function test_customer_sees_catalog_on_dashboard_and_stock_safety_is_enforced(): void
    {
        $customer = User::factory()->create(['role' => 'customer']);
        $category = Category::create(['name' => 'GPU', 'description' => 'Graphics cards']);
        $brand = Brand::create(['name' => 'NVIDIA', 'slug' => 'nvidia']);

        // In-stock product
        $inStockProduct = Product::create([
            'category_id' => $category->id,
            'brand_id' => $brand->id,
            'name' => 'GeForce RTX 4070 Super',
            'price' => 11000000,
            'stock' => 5,
        ]);

        // Out-of-stock product
        $outOfStockProduct = Product::create([
            'category_id' => $category->id,
            'brand_id' => $brand->id,
            'name' => 'GeForce RTX 4090 Sold Out Edition',
            'price' => 32000000,
            'stock' => 0,
        ]);

        // Customer visits dashboard
        $response = $this->actingAs($customer)->get(route('dashboard'));
        $response->assertOk();
        $response->assertSee('GeForce RTX 4070 Super');
        $response->assertSee('5 Tersedia');
        $response->assertSee('+ Keranjang');
        $response->assertSee('GeForce RTX 4090 Sold Out Edition');
        $response->assertSee('Stok Habis');

        // Attempting to add out of stock product to cart must fail
        $failCart = $this->actingAs($customer)->post(route('cart.store'), [
            'product_id' => $outOfStockProduct->id,
            'quantity' => 1,
        ]);
        $failCart->assertSessionHas('error');
        $this->assertDatabaseMissing('cart_items', [
            'product_id' => $outOfStockProduct->id,
        ]);

        // Attempting to add more than available stock must fail
        $failExcess = $this->actingAs($customer)->post(route('cart.store'), [
            'product_id' => $inStockProduct->id,
            'quantity' => 99,
        ]);
        $failExcess->assertSessionHas('error');
        $this->assertDatabaseMissing('cart_items', [
            'product_id' => $inStockProduct->id,
        ]);
    }
}
