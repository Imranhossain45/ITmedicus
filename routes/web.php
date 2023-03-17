<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Backend\CompanyController;
use App\Http\Controllers\Backend\EmployeeController;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['verify' => true]);

Route::middleware(['auth'])->group(
    function () {
        Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware('auth', 'verified');

        Route::controller(CompanyController::class)->prefix('company')->name('backend.company.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::get('/edit/{company}', 'edit')->name('edit');
            Route::post('/update/{company}', 'update')->name('update');
            Route::get('/destroy/{company}', 'destroy')->name('trash');
            Route::get('/status/{company}', 'status')->name('status');
            Route::get('/reStore/{id}', 'reStore')->name('reStore');
            Route::delete('/permDelete/{company}', 'permDelete')->name('delete');
        });
        Route::controller(EmployeeController::class)->prefix('employee')->name('backend.employee.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::get('/edit/{employee}', 'edit')->name('edit');
            Route::post('/update/{employee}', 'update')->name('update');
            Route::get('/destroy/{employee}', 'destroy')->name('trash');
            Route::get('/status/{employee}', 'status')->name('status');
            Route::get('/reStore/{id}', 'reStore')->name('reStore');
            Route::delete('/permDelete/{employee}', 'permDelete')->name('delete');
        });


    }
);

