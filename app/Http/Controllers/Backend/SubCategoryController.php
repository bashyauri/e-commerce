<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AddSubCategoryRequest;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    public function allSubCategory(): View
    {
        $subcategories = SubCategory::latest()->get();
        return view('backend.subcategory.all-subcategory', ['subcategories' => $subcategories]);
    }
    public function addSubCategory(): View
    {
        $categories = Category::all();


        return view('backend.subcategory.add-subcategory', ['categories' => $categories]);
    }
    public function storeSubCategory(AddSubCategoryRequest $request): RedirectResponse
    {

        $data = $request->validated();

        SubCategory::create([
            'category_id' => $data['category_id'],
            'subcategory_name' => $data['subcategory_name'],
            'subcategory_slug' => str()->slug($data['subcategory_name']),

        ]);

        $notifiction = ['message' => 'Subcategory Created Successfully !', 'alert-type' => 'success'];
        return redirect()->route('all.subcategory')->with($notifiction);
    }
}
