<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Repositories\Products\Interfaces\ProductInterface;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index (ProductInterface $productRepository) {
        dd($productRepository->getFeatured());
    }
}
