<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function productDetails(Product $product, string $slug): View
    {
        return view('frontend.product.product-details')->with('product', $product);
    }
}
