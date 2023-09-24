<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AddProductRequest;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Image as ModelsImage;
use App\Models\User;
use Carbon\Carbon;
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
            'product_color' => $data['product_color'],
            'short_descp' => $data['short_descp'],
            'long_descp' => $data['long_descp'],
            'selling_price' => $data['selling_price'],
            'product_thumbnail' => $savedUrl,
            'vendor_id' => $data['vendor_id'],
            'category_id' => $data['category_id'],
            'sub_category_id' => $data['sub_category_id'],
            'status' => 1,
            'created_at' => Carbon::now()

        ]);

        $images = $request->file('images');
        foreach ($images as $img) {
            $productImage = hexdec(uniqid()) . '.' . $img->getClientOriginalExtension();
            Image::make($img)->resize(800, 800)->save('uploads/product_images/images/' . $productImage);
            $imageUrl = 'uploads/product_images/images/' . $productImage;
            ModelsImage::create([
                'product_id' => $productId,
                'photo_name' => $imageUrl,
                'created_at' => Carbon::now()
            ]);
        }

        $notifiction = ['message' => 'Product Created Successfully !', 'alert-type' => 'success'];
        return redirect()->route('all.product')->with($notifiction);
    }
}
