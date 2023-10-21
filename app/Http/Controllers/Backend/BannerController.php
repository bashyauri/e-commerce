<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Image;

class BannerController extends Controller
{
    public function allBanner(): View
    {
        $banners = Banner::latest()->get();
        return view('backend.banner.all-banner', ['banners' => $banners]);
    }
}