<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Backend\BrandController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VendorController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('frontend.index');
});

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [UserController::class, 'userDashboard'])->name('dashboard');
    Route::post('/user/profile/store', [UserController::class, 'store'])->name('user.profile.store');
    Route::get('/user/logout', [UserController::class, 'logout'])->name('user.logout');
    Route::post('/user/update/password', [UserController::class, 'updatePassword'])->name('user.update.password');
});
// Group middleware end
// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';


// Admin Dashboard
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'adminDashboard'])->name('admin.dashboard');
    Route::get('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');
    Route::get('/admin/profile', [AdminController::class, 'profile'])->name('admin.profile');
    Route::post('/admin/profile/store', [AdminController::class, 'store'])->name('admin.profile.store');
    Route::get('/admin/change/password', [AdminController::class, 'changePassword'])->name('admin.change-password');
    Route::post('/admin/update/password', [AdminController::class, 'updatePassword'])->name('update.password');
});
// vendor Dashboard
Route::middleware(['auth', 'role:vendor'])->group(function () {
    Route::get('/vendor/logout', [VendorController::class, 'logout'])->name('vendor.logout');
    Route::get('/vendor/dashboard', [VendorController::class, 'vendorDashboard'])->name('vendor.dashboard');
    Route::get('/vendor/profile', [VendorController::class, 'profile'])->name('vendor.profile');
    Route::post('/vendor/profile/store', [VendorController::class, 'store'])->name('vendor.profile.store');
    Route::get('/vendor/change/password', [VendorController::class, 'changePassword'])->name('vendor.change-password');
    Route::post('/vendor/update/password', [VendorController::class, 'updatePassword'])->name('vendor.update.password');
});

Route::get('/admin/login', [AdminController::class, 'login']);
Route::get('/vendor/login', [VendorController::class, 'login']);

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::controller(BrandController::class)->group(function () {
        // All brand routes
        Route::get('/all/brand', 'allBrand')->name('all.brand');
        Route::get('/add/brand', 'addBrand')->name('add.brand');
    });
});