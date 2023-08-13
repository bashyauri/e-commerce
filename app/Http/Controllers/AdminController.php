<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminRequest;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
    public function store(AdminRequest $request)
    {
        $data = $request->validated();


        if ($request->file('photo')) {
            $file = $request->file('photo');
            unlink(public_path('uploads/admin_images/' . auth()->user()->photo));
            $filename = date('YmdHi') . $file->getClientOriginalName();
            $file->move(public_path('uploads/admin_images/'), $filename);
            $data['photo'] = $filename;
        }
        User::where(['id' => auth()->id()])->update($data);
        return redirect()->back();
    }
    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/admin/login');
    }
}
