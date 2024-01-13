<?php

namespace App\Providers;

use App\Models\Product;
use Illuminate\Support\ServiceProvider;
use App\Repositories\Products\Eloquent\ProductRepository;
use App\Repositories\Products\Interfaces\ProductInterface;

/**
 * @since 02/07/2016 09:50 AM
 */
class ProductServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(ProductInterface::class, function () {
            return new ProductRepository(new Product());
        });

    }

    public function boot(): void
    {

    }
}
