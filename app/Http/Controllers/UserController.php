<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\UserRequest;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function userDashboard(): View
    {
        $user = auth()->user();
        return view('index', ['user' => $user]);
    }
    public function store(UserRequest $request): RedirectResponse
    {
        $data = $request->validated();


        if ($request->hasFile('photo')) {
            $file = $request->file('photo');

            if (auth()->user()->photo) {
                $oldPhotoPath = public_path('uploads/user_images/' . auth()->user()->photo);
                if (file_exists($oldPhotoPath)) {
                    unlink($oldPhotoPath);
                }
            }

            $filename = date('YmdHi') . $file->getClientOriginalName();
            $file->move(public_path('uploads/user_images/'), $filename);
            $data['photo'] = $filename;
        }
        User::where(['id' => auth()->id()])->update($data);
        $notifiction = ['message' => 'User Profile updated!', 'alert-type' => 'success'];
        return redirect()->back()->with($notifiction);
    }
}