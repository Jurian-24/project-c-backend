<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanyController;

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
    return view('welcome');
});

Route::post('/login', [AuthController::class, 'login'])->name('authenticate-user');
Route::middleware(['authUser'])->group(function () {
    Route::get('/home', function () {
        return view('home');
    })->name('home');
    Route::get('/add-company', function () {
        return view('add-company');
    })->name('add-company');
    Route::post('adding-company', [CompanyController::class, 'create'])->name('company-adding');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});

// Route::get('/home', function () {
//     return view('home');
// });
