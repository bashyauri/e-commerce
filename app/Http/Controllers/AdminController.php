<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;



class AdminController extends Controller
{
    public function adminDashboard(): View
    {
        return view('admin.index');
    }
}
