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




Route::prefix('admin')->name('admin.')->group(function ()
{
    Route::get('login', [AdminAuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AdminAuthController::class, 'login']);
    Route::post('logout', [AdminAuthController::class, 'logout'])->name('logout');
});

Route::prefix('admin')->middleware('auth:admin')->group(function ()
{
    Route::get('dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('changepassword', [AdminController::class, 'changePass'])->name('admin.changepass');
    Route::post('change-password', [AdminController::class, 'changePassword'])->name('change-password');
});


Route::middleware('auth')->group(function ()
{
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// Admin Categories Routes
Route::prefix('admin')->name('admin.')->middleware('auth:admin')->group(function ()
{
    Route::get('categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('categories/{category}', [CategoryController::class, 'show'])->name('categories.show');
    Route::get('categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
});


// Admin Brands Routes
Route::prefix('admin')->name('admin.')->middleware('auth:admin')->group(function ()
{
    Route::get('brand', [BrandController::class, 'index'])->name('brands.index');
    Route::post('brand/store', [BrandController::class, 'store'])->name('brands.store');
    Route::post('brand/update/{id}', [BrandController::class, 'update'])->name('brands.update');
    Route::get('brand/delete/{id}', [BrandController::class, 'destroy'])->name('brands.destroy');
});













require __DIR__ . '/auth.php';
