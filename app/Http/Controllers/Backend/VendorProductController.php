<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AddProductRequest;
use App\Http\Requests\Admin\UpdateImageRequest;
use App\Http\Requests\Admin\UpdateProductRequest;
use App\Http\Requests\Admin\UpdateProductThumbnailRequest;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Image as ModelsImage;
use App\Models\SubCategory;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\View\View;
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
}
