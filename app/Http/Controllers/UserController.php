<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function userDashboard(): View
    {
        $user = auth()->user();
        return view('index', ['user' => $user]);
    }
}