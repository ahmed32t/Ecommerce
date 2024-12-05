<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\Admin;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CategoryController;

require base_path('routes/admin.php');
require base_path('routes/seller.php');
Route::get('/home', function () {
    return view('welcome');
});
/*
####how to turn off some Auth route#####

Auth::routes([
    'register'=>false
]);
*/


Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home.index');



/*
Route::middleware([Admin::class])->group(function () {
    Route::get('admin',[AdminController::class,'index'])->name('admindashboard');
});
*/
Route::middleware('auth')->group(function(){
    Route::get('user',[UserController::class,'index'])->name('userdashboard');
});
#####for seller####

###logout####
Route::middleware(['auth'])->group(function () {
    Route::get('user10',[UserController::class,'logout'])->name('user.logout');

});


