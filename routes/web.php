<?php

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

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('category')->name('category.')->group(function () {
        Route::get('/', [\App\Http\Controllers\CategoryController::class, 'index'])->name('index');
        Route::get('/create', [\App\Http\Controllers\CategoryController::class, 'create'])->name('create');
        Route::post('/save-create', [\App\Http\Controllers\CategoryController::class, 'saveCreate'])->name('saveCreate');
        Route::get('/update/{id}', [\App\Http\Controllers\CategoryController::class, 'update'])->name('update');
        Route::post('/save-update', [\App\Http\Controllers\CategoryController::class, 'saveUpdate'])->name('saveUpdate');
        Route::get('/remove/{id}', [\App\Http\Controllers\CategoryController::class, 'remove'])->name('remove');
    });

    Route::prefix('video')->name('video.')->group(function () {
        Route::get('/', [\App\Http\Controllers\VideoController::class, 'index'])->name('index');
        Route::get('/create', [\App\Http\Controllers\VideoController::class, 'create'])->name('create');
        Route::post('/save-create', [\App\Http\Controllers\VideoController::class, 'saveCreate'])->name('saveCreate');
        Route::get('/update/{id}', [\App\Http\Controllers\VideoController::class, 'update'])->name('update');
        Route::get('/save-update', [\App\Http\Controllers\VideoController::class, 'saveUpdate'])->name('saveUpdate');
        Route::get('/remove/{id}', [\App\Http\Controllers\VideoController::class, 'remove'])->name('remove');
    });
});
