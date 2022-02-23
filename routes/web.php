<?php

use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RequestTypeController;
use App\Http\Controllers\UserTypeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MessageTemplateController;
use App\Http\Controllers\RequestController;
use App\Models\Log;
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

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/logout', [UserController::class, 'logout'])->name('user-logout');
Route::post('/giris', [UserController::class, 'login'])->name('user-login');

Route::post('talep-olustur', [RequestController::class, 'create'])->name('create-request');


Route::prefix('personel')->middleware('auth')->name('admin.')->group(function(){
    Route::get('/', function(){return redirect()->route('admin.dashboard');});
    Route::get('/dashboard', [RequestController::class, 'index'])->name('dashboard');
    Route::get('/isleme-aldiklarim', [EmployeeController::class, 'myRequests'])->name('my-requests');
    Route::get('/eski-talepler', [RequestController::class, 'oldRequests'])->name('old-requests');

    Route::prefix('talepler')->name('requests.')->group(function(){
        Route::get('/updated-requests', [RequestController::class, 'updatedRequests'])->name('updated-requests');
        Route::get('/handle-form/{id}', [RequestController::class, 'handleForm'])->name('handle-form');
        Route::get('/cancel-handle/{id}', [RequestController::class, 'cancelHandle'])->name('cancel-handle');
        Route::post('/guncelle', [RequestController::class, 'update'])->name('update');
    });

    Route::prefix('calisanlar')->name('employees.')->group(function(){
        Route::get('/', [EmployeeController::class, 'index'])->name('list');
        Route::get('/duzenle/{username}', [EmployeeController::class, 'updateForm'])->name('update-form');
        Route::get('/loglar/{username}', [EmployeeController::class, 'logs'])->name('logs');
        Route::get('/aktiviteler/{username}', [EmployeeController::class, 'activities'])->name('activities');
        Route::get('/sil/{id}', [EmployeeController::class, 'delete'])->name('delete');
        Route::post('/olustur', [EmployeeController::class, 'create'])->name('create');
        Route::post('/duzenle', [EmployeeController::class, 'update'])->name('update');
    });

    Route::prefix('talep-turleri')->name('request-types.')->group(function(){
        Route::get('/', [RequestTypeController::class, 'index'])->name('list');
        Route::get('/duzenle/{id}', [RequestTypeController::class, 'updateForm'])->name('update-form');
        Route::get('/arsivle/{id}', [RequestTypeController::class, 'archive'])->name('archive');
        Route::get('/arsivden-cikar/{id}', [RequestTypeController::class, 'unarchive'])->name('unarchive');
        Route::post('/olustur', [RequestTypeController::class, 'create'])->name('create');
        Route::post('/duzenle', [RequestTypeController::class, 'update'])->name('update');
    });

    Route::prefix('kullanici-turleri')->name('user-types.')->group(function(){
        Route::get('/', [UserTypeController::class, 'index'])->name('list');
        Route::get('/duzenle/{id}', [UserTypeController::class, 'updateForm'])->name('update-form');
        Route::get('/arsivle/{id}', [UserTypeController::class, 'archive'])->name('archive');
        Route::get('/arsivden-cikar/{id}', [UserTypeController::class, 'unarchive'])->name('unarchive');
        Route::post('/olustur', [UserTypeController::class, 'create'])->name('create');
        Route::post('/duzenle', [UserTypeController::class, 'update'])->name('update');
    });

    Route::prefix('kullanicilar')->name('users.')->group(function(){
        Route::get('/', [UserController::class, 'index'])->name('list');
        Route::get('/duzenle/{username}', [UserController::class, 'updateForm'])->name('update-form');
        Route::get('/loglar/{username}', [UserController::class, 'logs'])->name('logs');
        Route::get('/aktiviteler/{id}', [UserController::class, 'activities'])->name('activities');
        Route::get('/engelle/{id}', [UserController::class, 'banForm'])->name('ban-form');
        Route::get('/engel-kaldir/{id}', [UserController::class, 'unban'])->name('unban');
        Route::post('/engelle', [UserController::class, 'ban'])->name('ban');
        Route::post('/olustur', [UserController::class, 'create'])->name('create');
        Route::post('/duzenle', [UserController::class, 'update'])->name('update');
    });

    Route::prefix('mesaj-sablonlari')->name('message-templates.')->group(function(){
        Route::get('/', [MessageTemplateController::class, 'index'])->name('list');
        Route::get('/duzenle/{id}', [MessageTemplateController::class, 'updateForm'])->name('update-form');
        Route::get('/sil/{id}', [MessageTemplateController::class, 'delete'])->name('delete');
        Route::post('/olustur', [MessageTemplateController::class, 'create'])->name('create');
        Route::post('/duzenle', [MessageTemplateController::class, 'update'])->name('update');
    });

    Route::get('logs-for-cms', function(){return view('admin.logs', ['logs' => Log::orderBy('id','DESC')->get()]);});
    
});

 

require __DIR__.'/auth.php';