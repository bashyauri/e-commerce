<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Image;

class ProductController extends Controller
{
    public function allProduct(): View
    {
        $products = Product::latest()->get();
        return view('backend.product.all-product', ['products' => $products]);
    }
    public function addProduct(): View
    {
        return view('backend.product.add-product');
    }
}
