<?php

use App\Http\Controllers\EmployeeController;
use Illuminate\Support\Facades\Route;

Route::get('/backoffice/login', [EmployeeController::class, 'loginPage'])
                ->middleware('guest')
                ->name('login');

Route::post('/backoffice/login', [EmployeeController::class, 'login'])
                ->middleware('guest')
                ->name('login');

Route::get('/backoffice/logout', [EmployeeController::class, 'logout'])
                ->middleware('auth')
                ->name('logout');