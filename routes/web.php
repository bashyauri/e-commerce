<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Backend\BrandController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\SubCategoryController;
use App\Http\Controllers\Backend\VendorProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VendorController;
use App\Http\Middleware\RedirectIfAuthenticated;
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

    Route::controller(VendorProductController::class)->group(function () {
        // All VendorProduct routes
        Route::get('/vendor/product', 'allVendorProduct')->name('vendor.product');
        Route::get('/vendor/add/product', 'addVendorProduct')->name('vendor.add-product');
        Route::get('/vendor/subcategory/ajax/{category_id}', 'getVendorSubCategory');
        Route::post('/vendor/add/product', 'storeVendorProduct')->name('vendor.store-product');
        Route::get('/vendor/edit/product/{product}', 'editVendorProduct')->name('vendor.edit-product');
        Route::put('/vendor/update/product/{product}', 'updateVendorProduct')->name('vendor.update-product');
        Route::patch('vendor/update/product-thumbnail/{product}', 'updateVendorProductThumbnail')->name('vendor.update.product-thumbnail');
        Route::put('vendor/update/product-image/{image}', 'updateVendorProductImage')->name('vendor.update.product-image');
        Route::delete('/vendor/delete/product-image/{image}', 'deleteVendorProductImage')->name('vendor.delete.product-image');
    });
});

Route::get('/admin/login', [AdminController::class, 'login'])->middleware(RedirectIfAuthenticated::class);;
Route::get('/vendor/login', [VendorController::class, 'login'])->name('vendor.login')->middleware(RedirectIfAuthenticated::class);;
Route::get('/become-vendor', [VendorController::class, 'becomeVendor'])->name('become.vendor');
Route::post('/vendor/register', [VendorController::class, 'register'])->name('vendor.register');

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::controller(BrandController::class)->group(function () {
        // All brand routes
        Route::get('/all/brand', 'allBrand')->name('all.brand');
        Route::get('/add/brand', 'addBrand')->name('add.brand');
        // Route::get('/add/brand', 'addBrand')->name('add.brand');
        Route::post('/store/brand', 'storeBrand')->name('store.brand');
        Route::get('/edit/brand/{id}', 'editBrand')->name('edit.brand');
        Route::post('/update/brand/', 'updateBrand')->name('update.brand');
        Route::delete('/delete/brand/{brand}', 'deleteBrand')->name('delete.brand');
    });

    Route::controller(CategoryController::class)->group(function () {
        // All category routes
        Route::get('/all/category', 'allCategory')->name('all.category');
        // Route::get('/add/category', 'addCategory')->name('add.category');
        Route::get('/add/category', 'addCategory')->name('add.category');
        Route::post('/store/category', 'storeCategory')->name('store.category');
        Route::get('/edit/category/{id}', 'editCategory')->name('edit.category');
        Route::post('/update/category/', 'updateCategory')->name('update.category');
        Route::delete('/delete/category/{category}', 'deleteCategory')->name('delete.category');
    });
    Route::controller(SubCategoryController::class)->group(function () {
        // All subcategory routes
        Route::get('/all/subcategory', 'allSubCategory')->name('all.subcategory');
        // Route::get('/add/category', 'addCategory')->name('add.subcategory');
        Route::get('/add/subcategory', 'addSubCategory')->name('add.subcategory');
        Route::post('/store/subcategory', 'storeSubCategory')->name('store.subcategory');
        Route::get('/edit/subcategory/{id}', 'editSubCategory')->name('edit.subcategory');
        Route::post('/update/subcategory/', 'updateSubCategory')->name('update.subcategory');
        Route::delete('/delete/subcategory/{subcategory}', 'deleteSubCategory')->name('delete.subcategory');
        Route::get('/subcategory/ajax/{category_id}', 'getSubCategory');
    });
    Route::controller(AdminController::class)->group(function () {
        // All Active and Inactive Vendors
        Route::get('/inactive/vendor', 'inactiveVendor')->name('inactive.vendor');
        Route::get('/active/vendor', 'activeVendor')->name('active.vendor');
        Route::get('/inactive/vendor-details/{vendor}', 'inactiveVendorDetails')->name('inactive.vendor-details');
        Route::get('/active/vendor-details/{vendor}', 'activeVendorDetails')->name('active.vendor-details');
        Route::patch('/activate/vendor/{vendor}', 'activateVendor')->name('activate.vendor');
        Route::patch('/deactivate/vendor/{vendor}', 'deactivateVendor')->name('deactivate.vendor');
    });
    Route::controller(ProductController::class)->group(function () {
        // All product routes
        Route::get('/all/product', 'allProduct')->name('all.product');
        Route::get('/add/product', 'addProduct')->name('add.product');
        Route::post('/add/product', 'storeProduct')->name('store.product');
        Route::get('/edit/product/{product}', 'editProduct')->name('edit.product');
        Route::patch('/update/product/{product}', 'updateProduct')->name('update.product');
        Route::patch('/update/product-thumbnail/{product}', 'updateProductThumbnail')->name('update.product-thumbnail');
        Route::put('/update/product-image/{image}', 'updateProductImage')->name('update.product-image');
        Route::delete('/delete/product-image/{image}', 'deleteProductImage')->name('delete.product-image');
        Route::patch('/inactive/product/{product}', 'inactiveProduct')->name('inactive.product');
        Route::patch('/active/product/{product}', 'activeProduct')->name('active.product');
        Route::delete('/delete/product/{product}', 'deleteProduct')->name('delete.product');
    });
});
