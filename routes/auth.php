<?php

use App\Http\Controllers\EmployeeController;
use Illuminate\Support\Facades\Route;

Route::get('/personel/login', [EmployeeController::class, 'loginPage'])
                ->middleware('guest')
                ->name('login');

Route::post('/personel/login', [EmployeeController::class, 'login'])
                ->middleware('guest')
                ->name('login');

Route::get('/personel/logout', [EmployeeController::class, 'logout'])
                ->middleware('auth')
                ->name('logout');
