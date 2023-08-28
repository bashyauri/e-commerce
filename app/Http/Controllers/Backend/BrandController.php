<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function allBrand(): View
    {
        $brands = Brand::latest()->get();
        return view('backend.brand.all-brand', ['brands' => $brands]);
    }
    public function addBrand(): View
    {
        return view('backend.brand.add-brand');
    }
}