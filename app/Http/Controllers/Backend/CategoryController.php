<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AddCategoryRequest;
use App\Http\Requests\Admin\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
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
    public function editCategory(string $id): View
    {
        $category = Category::findOrFail($id);
        return view('backend.category.edit-category', ['category' => $category]);
    }
    public function updateCategory(UpdateCategoryRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $oldImage = $data['old_image'];
        if (isset($data['category_image'])) {
            $image = $request->file('category_image');
            $nameGen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(120, 120)->save('uploads/category_images/' . $nameGen);
            $savedUrl = 'uploads/category_images/' . $nameGen;
            if (file_exists($oldImage)) {
                unlink($oldImage);
            }
            Category::findOrFail($data['id'])->update([
                'category_name' => $data['category_name'],
                'category_slug' => str()->slug($data['category_name']),
                'category_image' => $savedUrl,
            ]);

            $notifiction = ['message' => 'Category Updated with image Successfully !', 'alert-type' => 'success'];
            return redirect()->route('all.category')->with($notifiction);
        }
        Category::findOrFail($data['id'])->update([
            'category_name' => $data['category_name'],
            'category_slug' => str()->slug($data['category_name']),

        ]);

        $notifiction = ['message' => 'Category Updated without image Successfully !', 'alert-type' => 'success'];
        return redirect()->route('all.category')->with($notifiction);
    }
    public function deleteCategory(string $id): RedirectResponse
    {
        $category = Category::findOrFail($id);

        DB::transaction(function () use ($category) {
            $category->delete();
            unlink($category->category_image);
        });
        $notifiction = ['message' => 'Category Deleted Successfully !', 'alert-type' => 'success'];
        return redirect()->back()->with($notifiction);
    }
}