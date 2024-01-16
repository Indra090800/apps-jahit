<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['guest:buy'])->group(function(){
    Route::get('/', function () {
        return view('auth.login');
    })->name('login');
    Route::post('/proseslogin', [AuthController::class, 'proseslogin']);
});

Route::middleware(['guest:user'])->group(function(){
    Route::get('/panel', function () {
        return view('auth.loginadmin');
    })->name('loginadmin');

    Route::post('/loginadmin', [AuthController::class, 'loginadmin']);
});


Route::middleware(['auth:buy'])->group(function(){
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/proseslogout', [AuthController::class, 'proseslogout']);
    //update profile 
});

Route::middleware(['auth:user'])->group(function(){
    Route::get('panel/dashboardadmin', [DashboardController::class, 'dashboardadmin']);
    Route::get('/proseslogoutadmin', [AuthController::class, 'proseslogoutadmin']);
});


