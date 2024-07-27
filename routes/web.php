<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\InvoiceController;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::middleware(['role:admin'])->group(function () {
        Route::get('/admin', [HomeController::class, 'admin'])->name('admin');

        // Admin can view invoices but not perform CRUD operations
        Route::get('admin/invoices', [InvoiceController::class, 'index'])->name('admin.invoices.index');
        Route::get('admin/invoices/{invoice}', [InvoiceController::class, 'show'])->name('admin.invoices.show');
    });

    Route::middleware(['role:doctor'])->group(function () {
        Route::get('/doctor', [HomeController::class, 'doctor'])->name('doctor');

        Route::resource('invoices', InvoiceController::class);
    });

    Route::middleware(['role:patient'])->group(function () {
        Route::get('/patient', [HomeController::class, 'patient'])->name('patient');
    });
});