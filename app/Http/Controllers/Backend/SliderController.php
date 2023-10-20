<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    public function allSlider(): View
    {
        $sliders = Slider::latest()->get();
        return view('backend.slider.all-slider', ['sliders' => $sliders]);
    }
}
