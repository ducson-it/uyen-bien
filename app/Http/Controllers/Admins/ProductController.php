<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Repositories\Products\Interfaces\ProductInterface;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private $productRepo;
    public function __construct(ProductInterface $productRepo) {
        $this->productRepo = $productRepo;
    }
    public function index () {
        return view('admins.product.index');
    }
}
