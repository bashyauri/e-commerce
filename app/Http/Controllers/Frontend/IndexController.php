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
        $productColor = explode(',', $product->product_color);
        $productSize =  explode(',', $product->product_size);

        return view('frontend.product.product-details', [
            'product' => $product,
            'productColor' => $productColor,
            'productSize' => $productSize
        ]);
    }
}
