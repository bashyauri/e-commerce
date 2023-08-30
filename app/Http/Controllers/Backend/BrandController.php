<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AddBrandRequest;
use App\Models\Brand;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Image;

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
    public function storeBrand(AddBrandRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $image = $request->file('brand_image');
        $nameGen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
        Image::make($image)->resize(300, 300)->save('uploads/brand_images/' . $nameGen);
        $savedUrl = 'uploads/brand_images/' . $nameGen;
        Brand::create([
            'brand_name' => $data['brand_name'],
            'brand_slug' => str()->slug($data['brand_name']),
            'brand_image' => $savedUrl,
        ]);

        $notifiction = ['message' => 'Brand Created Successfully !', 'alert-type' => 'success'];
        return redirect()->route('all.brand')->with($notifiction);
    }
    public function editBrand($id): View
    {
        $brand = Brand::findOrFail($id);
        return view('backend.brand.edit-brand', ['brand' => $brand]);
    }
}
