<?php

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


Route::get('login', [App\Http\Controllers\AuthController::class, 'index'])->name('auth.login');
Route::post('login', [App\Http\Controllers\AuthController::class, 'login'])->name('auth.postLogin');
Route::post('logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('auth.logout');


Route::middleware([App\Http\Middleware\Logined::class])->group(function () {
    require __DIR__ . '/test.php';
    Route::post('change-theme', [App\Http\Controllers\UserController::class, 'changeTheme'])->name('users.changeTheme');

    Route::resource('users', App\Http\Controllers\UserController::class);
    Route::resource('mikrotik', App\Http\Controllers\MikrotikController::class);
    Route::resource('olt', App\Http\Controllers\OltController::class);
});
