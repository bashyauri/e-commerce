<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\UpdatePasswordRequest;
use App\Http\Requests\AdminRequest;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function adminDashboard(): View
    {
        return view('admin.index');
    }
    public function login(): View
    {
        return view('admin.login');
    }
    public function profile(): View
    {
        $user = auth()->user();
        return view('admin.profile', ['user' => $user]);
    }
    public function store(AdminRequest $request): RedirectResponse
    {
        $data = $request->validated();


        if ($request->hasFile('photo')) {
            $file = $request->file('photo');

            if (auth()->user()->photo) {
                $oldPhotoPath = public_path('uploads/admin_images/' . auth()->user()->photo);
                if (file_exists($oldPhotoPath)) {
                    unlink($oldPhotoPath);
                }
            }

            $filename = date('YmdHi') . $file->getClientOriginalName();
            $file->move(public_path('uploads/admin_images/'), $filename);
            $data['photo'] = $filename;
        }
        User::where(['id' => auth()->id()])->update($data);
        $notifiction = ['message' => 'Admin Profile updated!', 'alert-type' => 'success'];
        return redirect()->back()->with($notifiction);
    }
    public function changePassword(): View
    {
        return view('admin.change-password');
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
    public function inactiveVendor()
    {
        $inactiveVendors = User::where(['status' => 'inactive', 'role' => 'vendor'])
            ->latest()->get();
        return view('vendor.inactive-vendors', ['inactiveVendors' => $inactiveVendors]);
    }
    public function activeVendor()
    {
    }
    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/admin/login');
    }
}
