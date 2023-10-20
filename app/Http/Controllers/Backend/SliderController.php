<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AddSliderRequest;
use App\Models\Slider;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    public function allSlider(): View
    {
        $sliders = Slider::latest()->get();
        return view('backend.slider.all-slider', ['sliders' => $sliders]);
    }
    public function addSlider(): View
    {
        return view('backend.slider.add-slider');
    }
    public function storeSlider(AddSliderRequest $request): RedirectResponse
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
