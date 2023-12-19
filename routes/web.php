<?php
declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AttendanceController;

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

//password bcrypted: $2y$12$5CeAFIio/UpcRhHUGyOTwun5P1zc5qCybOw7SIvv2kMDOSr6u8HVS



Route::get('/', function () {
    return view('welcome');
})->name('login-page');


Route::post('/login', [AuthController::class, 'login'])->name('authenticate-user');
Route::get('company-verification/{token}/{id}', [CompanyController::class, 'verify'])->name('company-verification');
Route::post('/update-company/{company}', [CompanyController::class, 'update'])->name('update-company');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/complete-registration/{token}', [EmployeeController::class, 'register'])->name('registration-completion');
Route::post('/update-employee/{token}/{id}', [EmployeeController::class, 'update'])->name('update-employee');



Route::middleware(['companyAdmin'])->group(function () {
    Route::get('/company-admin-dashboard', function () {
        return view('company-admin.dashboard');
    })->name('company-admin-dashboard');
    Route::get('/add-employee', [EmployeeController::class, 'add'])->name('add-employee');
    Route::post('/add-employee', [EmployeeController::class, 'create'])->name('add-employee');
    Route::get('/products', [ProductController::class, 'index'])->name('get-products');
    // Route::get('/products/{title}', [ProductController::class, 'show'])->name('search-product');
    // Route::get('/products/categorie/{categorie}', [ProductController::class, 'searchCategorie'])->name('search-categorie');
});

Route::middleware(['employeeCheck'])->group(function () {
    Route::get('/employee-home', function () {
        return view('employee.dashboard');
    })->name('employee-home');
    Route::post('/update-attendance/{weekNumber}/{weekDay}', [AttendanceController::class, 'update'])->name('update-attendance');
    Route::get('/copy-attendance', [AttendanceController::class, 'copy'])->name('copy-attendance');
    Route::get('/attendance-schedule', [AttendanceController::class, 'index'])->name('attendance-schedule');
});

Route::middleware(['superAdmin'])->group(function () {
    Route::get('/home', function () {
        return view('super-admin.dashboard');
    })->name('home');
    Route::get('/add-company', function () {
        return view('super-admin.add-company');
    })->name('add-company');
    Route::get('company-overview', [CompanyController::class, 'index'])->name('company-overview');
    Route::delete('delete-company/{id}', [CompanyController::class, 'destroy'])->name('delete-company');
    Route::post('adding-company', [CompanyController::class, 'create'])->name('company-adding');
});

// Route::get('/home', function () {
//     return view('home');
// });
