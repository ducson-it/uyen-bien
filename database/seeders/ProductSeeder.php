<?php
namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        // Insert dummy products
        Product::create([
            'name' => 'sản phẩm 1',
            'category_id' => 1,
            'price' => 10000,
            'description' => 'miêu tả 1',
            'product_tag' => '10',
            'is_featured' => 1,
            'is_available' => 1
        ]);
    }
}
