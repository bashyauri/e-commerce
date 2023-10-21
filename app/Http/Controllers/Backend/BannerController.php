<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AddBannerRequest;
use App\Models\Banner;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Image;

class BannerController extends Controller
{
    public function allBanner(): View
    {
        $banners = Banner::latest()->get();
        return view('backend.banner.all-banner', ['banners' => $banners]);
    }
    public function addBanner(): View
    {
        return view('backend.banner.add-banner');
    }
    public function storeBanner(AddBannerRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $image = $request->file('banner_image');
        $nameGen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
        Image::make($image)->resize(768, 450)->save('uploads/banner_images/' . $nameGen);
        $savedUrl = 'uploads/banner_images/' . $nameGen;
        Banner::create([
            'banner_title' => $data['banner_title'],
            'banner_url' => $data['banner_url'],
            'banner_image' => $savedUrl,
        ]);

        $notifiction = ['message' => 'Banner Created Successfully !', 'alert-type' => 'success'];
        return to_route('all.banner')->with($notifiction);
    }
}