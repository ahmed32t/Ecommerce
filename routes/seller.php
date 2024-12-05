<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Middleware\Seller;
use App\Http\Controllers\CategoryforsellerController;
############seller dashboard####################
Route::middleware([Seller::class])->group(function () {
    Route::get('Seller10', function () {
        return view ('dashboard.seller');
    })->name('seller');
});

###seller routes#########################################################
Route::middleware([ Seller::class])->group(function () {
    Route::resource('seller',CategoryforsellerController::class,['except' => ['index',"update",'destroy']]);
});

Route::middleware([Seller::class])->group(function () {
    Route::get('showingitem',[CategoryforsellerController::class,'index'])->name('newindex2');
});




Route::middleware([Seller::class])->group(function () {
    Route::put('seller/update/{slug}',[CategoryforsellerController::class,'update'])->name('seller.update');
});



Route::middleware([Seller::class])->group(function () {
    Route::delete('seller/destory/{slug}',[CategoryforsellerController::class,'destroy'])->name('seller.destory');
});
Route::middleware([Seller::class])->group(function () {
    Route::get('seller.trash',[CategoryforsellerController::class,'trash'])->name('seller.trash');
});
Route::middleware([Seller::class])->group(function () {
    Route::get('seller.trash/{slug}',[CategoryforsellerController::class,'restore'])->name('seller.restore');
});
Route::middleware([Seller::class])->group(function () {
    Route::delete('seller.delete/{slug}',[CategoryforsellerController::class,'permanentDelete'])->name('seller.delete');
});

