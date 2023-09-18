<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use App\Models\User;
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
        $activeVendors = User::where(['status' => 'active', 'role' => 'vendor'])->latest()->get();
        $brands = Brand::latest()->get();
        $categories = Category::latest()->get();

        return view(
            'backend.product.add-product',
            ['brands' => $brands, 'categories' => $categories, 'activeVendors' => $activeVendors]
        );
    }
}