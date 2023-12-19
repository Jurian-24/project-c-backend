<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BasketController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\BasketItemController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth:sanctum'])->group(function () {
    // authentication routes

});

// company routes
Route::get('/get-companies', [CompanyController::class, 'index']);
Route::get('/get-company/{company}', [CompanyController::class, 'show']);
Route::post('/create-company', [CompanyController::class, 'create']);
Route::post('/update-company/{id}', [CompanyController::class, 'update']);
Route::post('/delete-company/{company}', [CompanyController::class, 'destroy']);

// employee routes
Route::get('/get-employees', [EmployeeController::class, 'index']);
Route::get('/get-employee/{id}', [EmployeeController::class, 'show']);
Route::post('/create-employee', [EmployeeController::class, 'create']);
// Route::post('/update-employee/{id}', [EmployeeController::class, 'update']);
Route::post('/complete-registration/{token}', [EmployeeController::class, 'update']);
Route::post('/delete-employee/{employeeId}', [EmployeeController::class, 'destroy']);

Route::get('/get-attendance/{employeeId}', [AttendanceController::class, 'index']);
Route::post('/update-attendance/{weekNumber}/{weekDay}', [AttendanceController::class, 'update']);
Route::get('/products/{title}', [ProductController::class, 'show'])->name('search-product');
Route::get('/products/categorie/{categorie}', [ProductController::class, 'searchCategorie'])->name('search-categorie');

// basket routes
Route::post('/create-basket', [BasketController::class, 'create'])->name('add-to-basket');
Route::get('/get-basket', [BasketController::class, 'show'])->name('get-basket');
Route::post('/update-basket-item', [BasketItemController::class, 'update'])->name('update-basket-item');
Route::post('/delete-basket-item', [BasketItemController::class, 'destroy'])->name('delete-basket-item');

// checkout routes
Route::post('/checkout', [BasketController::class, 'checkout'])->name('checkout');

Route::get('/products/{title}', [ProductController::class, 'show'])->name('search-product');
Route::get('/products/categorie/{categorie}', [ProductController::class, 'searchCategorie'])->name('search-categorie');

// Route::post('/update-attendance/{weekNumber}/{weekDay}', [AttendanceController::class, 'update'])->name('update-attendance');
