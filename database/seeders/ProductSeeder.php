<?php
namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        // Insert dummy products
        for ($i=1; $i < 30; $i++) {
            Product::create([
                'name' => 'sản phẩm '. $i,
                'category_id' => $i,
                'price' => 10000 . $i,
                'description' => 'miêu tả '.$i,
                'product_tag' => $i,
                'is_featured' => 1,
                'is_available' => 1
            ]);
        }
    }
}
