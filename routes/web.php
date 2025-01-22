<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Middleware\Admin;
use App\Http\Controllers\AdminController;

Route::get('/',[HomeController::class,'home']);

Route::get('/dashboard',[HomeController::class,'login_home'])->
middleware(['auth', 'verified'])->name('dashboard');

Route::get('/myorders',[HomeController::class,'myorders'])->
middleware(['auth', 'verified']);


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

route::get('admin/dashboard',[HomeController::class,'index'])->
middleware(['auth','admin']);

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('view_category', [AdminController::class, 'view_category'])->name('view_category');
    Route::post('add_category', [AdminController::class, 'add_category'])->name('add_category');
    Route::delete('delete_category/{id}', [AdminController::class, 'delete_category'])->name('delete_category');
    Route::get('edit_category/{id}', [AdminController::class, 'edit_category'])->name('edit_category');
    Route::post('update_category/{id}', [AdminController::class, 'update_category'])->name('update_category');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('view_product', [AdminController::class, 'view_product'])->name('view_product');
    Route::get('add_product', [AdminController::class, 'add_product'])->name('add_product');
    Route::post('upload_product', [AdminController::class, 'upload_product'])->name('upload_product');
    Route::delete('delete_product/{id}', [AdminController::class, 'delete_product'])->name('delete_product');
    Route::get('update_product/{id}', [AdminController::class, 'update_product'])->name('update_product');
    Route::post('edit_product/{id}', [AdminController::class, 'edit_product'])->name('edit_product');
    Route::get('product_search', [AdminController::class, 'product_search'])->name('product_search');
});


route::get('product_details/{id}',[HomeController::class,'product_details']);

route::get('add_cart/{id}',[HomeController::class,'add_cart'])->name('add_cart')->
middleware(['auth','verified']);

route::get('mycart',[HomeController::class,'mycart'])->name('mycart')->
middleware(['auth','verified']);

route::get('delete_cart/{id}',[HomeController::class,'delete_cart'])->name('delete_cart')->
middleware(['auth','verified']);

route::post('confirm_order',[HomeController::class,'confirm_order'])->
middleware(['auth','verified']);

route::get('view_order',[AdminController::class,'view_order'])->
middleware(['auth','admin']);

route::get('view_order',[AdminController::class,'view_order'])->name('view_order')->
middleware(['auth','admin']);

route::get('on_the_way/{id}',[AdminController::class,'on_the_way'])->name('on_the_way')->
middleware(['auth','admin']);

route::get('delivered/{id}',[AdminController::class,'delivered'])->name('delivered')->
middleware(['auth','admin']);

