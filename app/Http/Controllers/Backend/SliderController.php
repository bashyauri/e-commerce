<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AddSliderRequest;
use App\Http\Requests\Admin\UpdateSliderRequest;
use App\Models\ModelsImage;
use App\Models\Slider;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        return to_route('all.slider')->with($notifiction);
    }
    public function editSlider(string $id): View
    {
        $slider = Slider::findOrFail($id);
        return view('backend.slider.edit-slider', ['slider' => $slider]);
    }
    public function updateSlider(UpdateSliderRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $oldImage = $data['old_image'];
        if (isset($data['slider_image'])) {
            $image = $request->file('slider_image');
            $nameGen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(2786, 807)->save('uploads/slider_images/' . $nameGen);
            $savedUrl = 'uploads/slider_images/' . $nameGen;
            if (file_exists($oldImage)) {
                unlink($oldImage);
            }
            Slider::findOrFail($data['id'])->update([
                'slider_title' => $data['slider_title'],
                'short_title' => $data['short_title'],
                'slider_image' => $savedUrl,
            ]);

            $notifiction = ['message' => 'Slider Updated with image Successfully !', 'alert-type' => 'success'];
            return redirect()->route('all.slider')->with($notifiction);
        }
        Slider::findOrFail($data['id'])->update([
            'slider_title' => $data['slider_title'],
            'short_title' => $data['short_title'],

        ]);

        $notifiction = ['message' => 'Slider Updated without image Successfully !', 'alert-type' => 'success'];
        return redirect()->route('all.slider')->with($notifiction);
    }
    public function deleteSlider(Slider $slider): RedirectResponse
    {


        DB::transaction(function () use ($slider) {
            $slider->delete();
            unlink($slider->slider_image);
        });
        $notifiction = ['message' => 'Slider Deleted Successfully !', 'alert-type' => 'success'];
        return redirect()->back()->with($notifiction);
    }
}
