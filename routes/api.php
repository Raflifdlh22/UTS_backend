<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeesController;
use App\Http\Controllers\Authcontroller;
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


Route::middleware('auth:sanctum')->Group(function () {
    // route untuk menampilkan seluruh employees
    route::get('/employees', [EmployeesController::class, 'index']);
    // route untuk menambahkan data employees
    route::post('/employees', [EmployeesController::class, 'store']);
    // route untuk menampilkan employees berdasarkan name
    route::get('/employees/{id}', [EmployeesController::class, 'show']);
    // route untuk mengubah data employees
    route::put('/employees/{id}', [EmployeesController::class, 'update']);
    // route untuk menghapus data employees
    route::delete('/employees/{id}', [EmployeesController::class, 'destroy']);
    // route untuk mencari resource 
    route::get('/employees/search/{name}', [EmployeesController::class, 'search']);
    // route untuk mendapatkan resource yang aktif
    route::get('/employees/status/active', [EmployeesController::class, 'active']);
    // route untuk mendapatkan resource yang tidak aktif
    route::get('/employees/status/inactive', [EmployeesController::class, 'inactive']);
    // route untuk mendapatkan resource yang diberhentikan
    route::get('/employees/status/terminated', [EmployeesController::class, 'terminated']);
});

//Route untuk login dan register 
route::post('/login', [AuthController::class, 'login']);
route::post('/register', [AuthController::class, 'register']);
//logout
route::post('/logout', [AuthController::class, 'logout']);
