<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AddCategoryRequest;
use App\Models\Category;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Image;


class CategoryController extends Controller
{
    public function allCategory(): View
    {
        $categories = Category::latest()->get();
        return view('backend.category.all-category', ['categories' => $categories]);
    }
    public function addCategory(): View
    {
        return view('backend.category.add-category');
    }
    public function storeCategory(AddCategoryRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $image = $request->file('category_image');
        $nameGen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
        Image::make($image)->resize(120, 120)->save('uploads/category_images/' . $nameGen);
        $savedUrl = 'uploads/category_images/' . $nameGen;
        Category::create([
            'category_name' => $data['category_name'],
            'category_slug' => str()->slug($data['category_name']),
            'category_image' => $savedUrl,
        ]);

        $notifiction = ['message' => 'Category Created Successfully !', 'alert-type' => 'success'];
        return redirect()->route('all.category')->with($notifiction);
    }
}