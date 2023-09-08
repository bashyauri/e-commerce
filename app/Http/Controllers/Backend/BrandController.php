<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AddBrandRequest;
use App\Http\Requests\Admin\UpdateBrandRequest;
use App\Models\Brand;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
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
    public function editBrand(string $id): View
    {
        $brand = Brand::findOrFail($id);
        return view('backend.brand.edit-brand', ['brand' => $brand]);
    }
    public function updateBrand(UpdateBrandRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $oldImage = $data['old_image'];
        if (isset($data['brand_image'])) {
            $image = $request->file('brand_image');
            $nameGen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(300, 300)->save('uploads/brand_images/' . $nameGen);
            $savedUrl = 'uploads/brand_images/' . $nameGen;
            if (file_exists($oldImage)) {
                unlink($oldImage);
            }
            Brand::findOrFail($data['id'])->update([
                'brand_name' => $data['brand_name'],
                'brand_slug' => str()->slug($data['brand_name']),
                'brand_image' => $savedUrl,
            ]);

            $notifiction = ['message' => 'Brand Updated with image Successfully !', 'alert-type' => 'success'];
            return redirect()->route('all.brand')->with($notifiction);
        }
        Brand::findOrFail($data['id'])->update([
            'brand_name' => $data['brand_name'],
            'brand_slug' => str()->slug($data['brand_name']),

        ]);

        $notifiction = ['message' => 'Brand Updated without image Successfully !', 'alert-type' => 'success'];
        return redirect()->route('all.brand')->with($notifiction);
    }
    public function deleteBrand(Brand $brand): RedirectResponse
    {


        DB::transaction(function () use ($brand) {
            $brand->delete();
            unlink($brand->brand_image);
        });
        $notifiction = ['message' => 'Brand Deleted Successfully !', 'alert-type' => 'success'];
        return redirect()->back()->with($notifiction);
    }
}
