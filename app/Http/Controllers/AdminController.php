<?php

namespace App\Http\Controllers;

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
    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/admin/login');
    }
}
