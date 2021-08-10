<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "Api" middleware group. Enjoy building your API!
|
*/

/*Route::middleware('auth:Api')->get('/user', function (Request $request) {
    return $request->user();
});*/

/*  API Versions 1 */
Route::prefix('/v1')->name('apiV1.')->group(function () {
    Route::get('/vocabulary/list', [\App\Http\Controllers\Api\V1\EnglishApiController::class, 'vocabularyList'])->name('Api.get.vocabulary');
    Route::get('/vocabulary-cat/list', [\App\Http\Controllers\Api\V1\EnglishApiController::class, 'vocabularyCatList'])->name('Api.get.vocabulary.cat');
    Route::get('/topics/list', [\App\Http\Controllers\Api\V1\EnglishApiController::class, 'topicsList'])->name('Api.get.vocabulary.cat');
});
/* END API Version 1 */

/*  API Versions 2 */
Route::prefix('/v2')->name('apiV2.')->group(function () {
    Route::get('/get-books', [\App\Http\Controllers\Api\V2\EnglishApiController::class, 'getBooks'])->name('Api.get.books');

});
/* END API Version 2 */
