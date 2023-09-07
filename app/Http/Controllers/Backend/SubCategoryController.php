<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\SubCategory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    public function allSubCategory(): View
    {
        $subcategories = SubCategory::latest()->get();
        return view('backend.subcategory.all-subcategory', ['subcategories' => $subcategories]);
    }
}