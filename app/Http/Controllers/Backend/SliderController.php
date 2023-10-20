<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AddSliderRequest;
use App\Models\ModelsImage;
use App\Models\Slider;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Image;

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
        $image = $request->file('slider_image');
        $nameGen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
        Image::make($image)->resize(2786, 807)->save('uploads/slider_images/' . $nameGen);
        $savedUrl = 'uploads/slider_images/' . $nameGen;
        Slider::create([
            'slider_title' => $data['slider_title'],
            'short_title' => $data['short_title'],
            'slider_image' => $savedUrl,
        ]);

        $notifiction = ['message' => 'Slider Created Successfully !', 'alert-type' => 'success'];
        return redirect()->route('all.slider')->with($notifiction);
    }
}
