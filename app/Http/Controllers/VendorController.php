<?php

namespace App\Http\Controllers;

use App\Http\Requests\Vendor\UpdatePasswordRequest;
use App\Http\Requests\Vendor\VendorRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class VendorController extends Controller
{
    public function vendorDashboard(): View
    {
        return view('vendor.index');
    }
    public function login(): View
    {
        return view('vendor.login');
    }
    public function profile(): View
    {
        $user = auth()->user();
        return view('vendor.profile', ['user' => $user]);
    }
    public function store(VendorRequest $request): RedirectResponse
    {
        $data = $request->validated();


        if ($request->file('photo')) {
            $file = $request->file('photo');
            if (file_exists(public_path('uploads/vendor_images/' . auth()->user()->photo))) {
                unlink(public_path('uploads/vendor_images/' . auth()->user()->photo));
            }
            $filename = date('YmdHi') . $file->getClientOriginalName();
            $file->move(public_path('uploads/vendor_images/'), $filename);
            $data['photo'] = $filename;
        }
        auth()->user()->update($data);

        $notifiction = ['message' => 'Vendor Profile updated!', 'alert-type' => 'success'];
        return redirect()->back()->with($notifiction);
    }
    public function changePassword(): View
    {
        return view('vendor.change-password');
    }
    public function updatePassword(UpdatePasswordRequest $request): RedirectResponse
    {
        $data = $request->validated();


        if (!Hash::check($data['current_password'], auth()->user()->password)) {
            return back()->with('error', 'Current password does not match');
        }
        auth()->user()->update([
            'password' => Hash::make($data['new_password']),
        ]);

        return back()->with('success', 'Password has been updated');
    }
    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/vendor/login');
    }
}