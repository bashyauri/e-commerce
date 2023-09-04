<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function allCategory(): View
    {
        $categories = Category::latest()->get();
        return view('backend.category.all-category', ['categories' => $categories]);
    }
}
