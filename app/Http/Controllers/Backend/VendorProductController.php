<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Vendor\StoreVendorRequest;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Image as ModelsImage;
use App\Models\SubCategory;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Image;
use Illuminate\Http\Request;

class VendorProductController extends Controller
{
    public function allVendorProduct(): View
    {
        $products = Product::where(['vendor_id' => auth()->user()->id])->latest()->get();
        return view('vendor.backend.product.all-product', ['products' => $products]);
    }
    public function addVendorProduct(): View
    {

        $brands = Brand::latest()->get();
        $categories = Category::latest()->get();

        return view(
            'vendor.backend.product.add-product',
            ['brands' => $brands, 'categories' => $categories]
        );
    }
    public function storeVendorProduct(StoreVendorRequest $request): RedirectResponse
    {
        $data = $request->validated();
        DB::transaction(function () use ($data, $request) {
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
                'product_size' => $data['product_size'],
                'product_tags' => $data['product_tags'],
                'product_color' => $data['product_color'],
                'short_descp' => $data['short_descp'],
                'long_descp' => $data['long_descp'],
                'selling_price' => $data['selling_price'],
                'discount_price' => $data['discount_price'],
                'product_thumbnail' => $savedUrl,
                'vendor_id' => auth()->user()->id,
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
        });


        $notifiction = ['message' => 'Vendor Product Created Successfully !', 'alert-type' => 'success'];
        return redirect()->route('vendor.product')->with($notifiction);
    }
    public function getVendorSubCategory($category_id): JsonResponse
    {

        $subcat = SubCategory::where('category_id', $category_id)->orderBy('subcategory_name', 'ASC')->get();
        return response()->json($subcat);
    }
}
