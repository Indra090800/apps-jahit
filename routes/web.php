<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HargaController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\RoleController;
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

    Route::get('/register', [PelangganController::class, 'register']);
    Route::post('/addreg', [PelangganController::class, 'addreg']);
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

    //Harga
    Route::get('/master/harga', [HargaController::class, 'index']);
    Route::post('/addHarga', [HargaController::class, 'addHarga']);
    Route::post('/jenis/{jenis_id}/edit', [HargaController::class, 'editHarga']);
    Route::post('/jenis/{jenis_id}/delete', [HargaController::class, 'delete']);

    //pelanggan
    Route::get('/master/pelanggan', [PelangganController::class, 'index']);
    Route::post('/addPelanggan', [PelangganController::class, 'addPelanggan']);
    Route::post('/pelanggan/{pelanggan_id}/edit', [PelangganController::class, 'editPelanggan']);
    Route::post('/pelanggan/{pelanggan_id}/delete', [PelangganController::class, 'delete']);

    //role
    Route::get('/master/role', [RoleController::class, 'index']);
    Route::post('/addRole', [RoleController::class, 'addRole']);
    Route::post('/role/{id_role}/edit', [RoleController::class, 'editRole']);
    Route::post('/role/{id_role}/delete', [RoleController::class, 'delete']);
});


