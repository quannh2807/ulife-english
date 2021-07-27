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

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Backend\DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('category')->name('category.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Backend\CategoryController::class, 'index'])->name('index');
        Route::get('/create', [\App\Http\Controllers\Backend\CategoryController::class, 'create'])->name('create');
        Route::post('/save-create', [\App\Http\Controllers\Backend\CategoryController::class, 'saveCreate'])->name('saveCreate');
        Route::get('/update/{id}', [\App\Http\Controllers\Backend\CategoryController::class, 'update'])->name('update');
        Route::post('/save-update', [\App\Http\Controllers\Backend\CategoryController::class, 'saveUpdate'])->name('saveUpdate');
        Route::get('/remove/{id}', [\App\Http\Controllers\Backend\CategoryController::class, 'remove'])->name('remove');
    });

    Route::prefix('video')->name('video.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Backend\VideoController::class, 'index'])->name('index');
        Route::get('/create', [\App\Http\Controllers\Backend\VideoController::class, 'create'])->name('create');
        Route::post('/save-create', [\App\Http\Controllers\Backend\VideoController::class, 'saveCreate'])->name('saveCreate');
        Route::get('/update/{id}', [\App\Http\Controllers\Backend\VideoController::class, 'update'])->name('update');
        Route::get('/save-update', [\App\Http\Controllers\Backend\VideoController::class, 'saveUpdate'])->name('saveUpdate');
        Route::get('/remove/{id}', [\App\Http\Controllers\Backend\VideoController::class, 'remove'])->name('remove');
    });

    Route::prefix('question')->name('question.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Backend\QuestionController::class, 'index'])->name('index');
        Route::get('/create', [\App\Http\Controllers\Backend\QuestionController::class, 'create'])->name('create');
    });

    Route::prefix('level')->name('level.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Backend\LevelsController::class, 'index'])->name('index');
        Route::get('/create', [\App\Http\Controllers\Backend\LevelsController::class, 'create'])->name('create');
        Route::post('/store', [\App\Http\Controllers\Backend\LevelsController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [\App\Http\Controllers\Backend\LevelsController::class, 'edit'])->name('edit');
        Route::post('/update', [\App\Http\Controllers\Backend\LevelsController::class, 'update'])->name('update');
        Route::get('/remove/{id}', [\App\Http\Controllers\Backend\LevelsController::class, 'remove'])->name('remove');
    });

    Route::prefix('topics')->name('topics.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Backend\TopicsController::class, 'index'])->name('index');
        Route::get('/create', [\App\Http\Controllers\Backend\TopicsController::class, 'create'])->name('create');
        Route::post('/store', [\App\Http\Controllers\Backend\TopicsController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [\App\Http\Controllers\Backend\TopicsController::class, 'edit'])->name('edit');
        Route::post('/update', [\App\Http\Controllers\Backend\TopicsController::class, 'update'])->name('update');
        Route::get('/remove/{id}', [\App\Http\Controllers\Backend\TopicsController::class, 'remove'])->name('remove');
    });

});
