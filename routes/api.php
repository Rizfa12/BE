<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\SuratMasukController;
use App\Http\Controllers\SuratKeluarController;
use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\StaffController;
use App\Http\Controllers\Api\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [App\Http\Controllers\Api\RegisterController::class, 'register'])->name('register');
Route::post('/login', App\Http\Controllers\Api\LoginController::class)->name('login');
Route::post('/logout', App\Http\Controllers\Api\LogoutController::class)->name('logout');
Route::get('/users', [UserController::class, 'index']);
Route::delete('/users/{id}', [UserController::class, 'destroy']);



Route::get('/surat-masuk', [SuratMasukController::class, 'index']);
Route::post('/surat-masuk', [SuratMasukController::class, 'store']);
Route::get('/surat-masuk/{id}', [SuratMasukController::class, 'show']);
Route::put('/surat-masuk/{id}', [SuratMasukController::class, 'update']);
Route::delete('/surat-masuk/{id}', [SuratMasukController::class, 'destroy']);

Route::get('/surat-keluar', [SuratKeluarController::class, 'index']);
Route::post('/surat-keluar', [SuratKeluarController::class, 'store']);
Route::get('/surat-keluar/{id}', [SuratKeluarController::class, 'show']);
Route::put('/surat-keluar/{id}', [SuratKeluarController::class, 'update']);
Route::delete('/surat-keluar/{id}', [SuratKeluarController::class, 'destroy']);

Route::resource('kategori', KategoriController::class);
Route::get('/kategori', [KategoriController::class, 'index']);
Route::post('/kategori', [KategoriController::class, 'store']);
Route::get('/kategori/{id}', [KategoriController::class, 'show']);
Route::put('/kategori/{id}', [KategoriController::class, 'update']);
Route::delete('/kategori/{id}', [KategoriController::class, 'destroy']);


Route::middleware(['auth:api', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard']);
});

Route::middleware(['auth:api', 'role:staff'])->group(function () {
    Route::get('/staff/dashboard', [StaffController::class, 'dashboard']);
});
