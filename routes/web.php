<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\ProfileController;

use App\Http\Controllers\BrandController;
use Illuminate\Support\Facades\Route;

Route::get('/', function ()
{
    return view('welcome');
});

Route::get('/dashboard', function ()
{
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');



//Admin Login Logout
Route::prefix('admin')->name('admin.')->group(function ()
{
    Route::get('login', [AdminAuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AdminAuthController::class, 'login']);
    Route::post('logout', [AdminAuthController::class, 'logout'])->name('logout');
});


Route::middleware("auth:admin")->prefix('admin')->name('admin.')->group(function ()
{
    Route::get('dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::get('change-password', [AdminController::class, 'changePass'])->name('changepass');
    Route::post('change-password', [AdminController::class, 'changePassword'])->name('change-password');

    // Admin Categories Routes
    Route::prefix('categories')->name('categories.')->group(function ()
    {
        Route::get('/', [CategoryController::class, 'index'])->name('index');
        Route::get('create', [CategoryController::class, 'create'])->name('create');
        Route::post('store', [CategoryController::class, 'store'])->name('store');
        Route::get('show/{id}', [CategoryController::class, 'show'])->name('show');
        Route::get('edit/{id}', [CategoryController::class, 'edit'])->name('edit');
        Route::post('update/{id}', [CategoryController::class, 'update'])->name('update');
        Route::get('destroy/{id}', [CategoryController::class, 'destroy'])->name('destroy');
    });


    // Admin Brands Routes
    Route::prefix('brand')->name('brands.')->group(function ()
    {
        Route::get('/', [BrandController::class, 'index'])->name('index');
        Route::post('store', [BrandController::class, 'store'])->name('store');
        Route::post('update/{id}', [BrandController::class, 'update'])->name('update');
        Route::get('delete/{id}', [BrandController::class, 'destroy'])->name('destroy');
    });
});













































Route::middleware('auth')->group(function ()
{
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
