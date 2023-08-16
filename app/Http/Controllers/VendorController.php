<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    public function vendorDashboard(): View
    {
        return view('vendor.index');
    }
}