<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Image;
use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function productDetails(Product $product, string $slug): View
    {
        $productColor = explode(',', $product->product_color);
        $productSize =  explode(',', $product->product_size);
        $images = Image::where('product_id', $product->id)->get();
        $relatedProducts = Product::where('id', '!=', $product->id)->where(['category_id' => $product->category_id])
            ->orderBy('id', 'DESC')
            ->limit(4)
            ->get();


        return view('frontend.product.product-details', [
            'product' => $product,
            'productColor' => $productColor,
            'productSize' => $productSize,
            'images' => $images,
            'relatedProducts' => $relatedProducts
        ]);
    }
}