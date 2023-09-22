<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AddProductRequest;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
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
    public function storeProduct(AddProductRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $image = $request->file('product_thumbnail');
        $nameGen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
        Image::make($image)->resize(800, 800)->save('uploads/product_images/thumbnails/' . $nameGen);
        $savedUrl = 'uploads/product_images/thumbnails/' . $nameGen;
        $productId = Product::insertGetId([
            'brand_id' => $data['brand_id'],
            'product_name' => $data['product_name'],
            'product_slug' => str()->slug($data['product_name']),
            'product_code' => $data['product_code'],
            'product_qty' => $data['product_qty'],
            'product_tags' => $data['product_tags'],
            'product_size' => $data['product_size'],
            'product_color' => $data['product_color'],
            'selling_price' => $data['selling_price'],
            'product_thumbnail' => $savedUrl,
            'vendor_id' => $data['vendor_id'],

        ]);
        $notifiction = ['message' => 'Category Created Successfully !', 'alert-type' => 'success'];
        return redirect()->route('all.category')->with($notifiction);
    }
}