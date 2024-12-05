<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Middleware\Admin;
use App\Http\Controllers\CategoryController;
###admin dashboard
Route::middleware(['auth',Admin::class])->group(function () {
    Route::get('admin',[AdminController::class,'index'])->name('admindashboard');
});
###admin category routes#########################################################
Route::middleware([ Admin::class])->group(function () {
    Route::resource('category',CategoryController::class,['except' => ['index',"update",'destroy']]);
});

Route::middleware([Admin::class])->group(function () {
    Route::get('showingcategory',[CategoryController::class,'index'])->name('newindex');
});




Route::middleware([Admin::class])->group(function () {
    Route::put('category/update/{slug}',[CategoryController::class,'update'])->name('category.update');
});



Route::middleware([Admin::class])->group(function () {
    Route::delete('category/destory/{slug}',[CategoryController::class,'destroy'])->name('category.destory');
});
Route::middleware([Admin::class])->group(function () {
    Route::get('category.trash',[CategoryController::class,'trash'])->name('category.trash');
});
Route::middleware([Admin::class])->group(function () {
    Route::get('category.restore12/{slug}',[CategoryController::class,'restore'])->name('category.restore');
});
Route::middleware([Admin::class])->group(function () {
    Route::get('category.restore/{slug}',[CategoryController::class,'restoreallproduct'])->name('category.restoreallproduct');
});
Route::middleware([Admin::class])->group(function () {
    Route::delete('category.delete/{slug}',[CategoryController::class,'permanentDelete'])->name('category.delete');
});
