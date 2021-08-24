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

    Route::get('/vocabulary/list', [\App\Http\Controllers\Api\V1\ApiVocabularyController::class, 'vocabularyList'])->name('Api.get.vocabulary.list');
    Route::get('/vocabulary/{id}', [\App\Http\Controllers\Api\V1\ApiVocabularyController::class, 'vocabularyDetail'])->name('Api.get.vocabulary.detail');
    Route::get('/vocabulary-cat/list', [\App\Http\Controllers\Api\V1\ApiVocabularyController::class, 'vocabularyCatList'])->name('Api.get.vocabulary.cat.list');
    Route::get('/vocabulary-cat/{id}', [\App\Http\Controllers\Api\V1\ApiVocabularyController::class, 'vocabularyCatDetail'])->name('Api.get.vocabulary.cat.detail');

    Route::get('/topics/list', [\App\Http\Controllers\Api\V1\ApiTopicsController::class, 'topicsList'])->name('Api.get.topics.list');
    Route::get('/topics/{id}', [\App\Http\Controllers\Api\V1\ApiTopicsController::class, 'topicsDetail'])->name('Api.get.topics.detail');

    Route::get('/lesson/list', [\App\Http\Controllers\Api\V1\ApiLessonController::class, 'lessonList'])->name('Api.get.lesson.list');
    Route::get('/lesson-course/list', [\App\Http\Controllers\Api\V1\ApiLessonController::class, 'lessonCourseList'])->name('Api.get.lessonCourse.list');

    Route::get('/course/list', [\App\Http\Controllers\Api\V1\ApiCourseController::class, 'courseList'])->name('Api.get.course.list');
    Route::get('/course/{id}', [\App\Http\Controllers\Api\V1\ApiCourseController::class, 'courseDetail'])->name('Api.get.course.detail');

    Route::get('/level/list', [\App\Http\Controllers\Api\V1\ApiLevelsController::class, 'levelList'])->name('Api.get.level.list');
    Route::get('/level/{id}', [\App\Http\Controllers\Api\V1\ApiLevelsController::class, 'levelDetail'])->name('Api.get.level.detail');

    Route::get('/video/list', [\App\Http\Controllers\Api\V1\ApiVideoController::class, 'videoList'])->name('Api.get.video.list');
    Route::get('/video/{id}', [\App\Http\Controllers\Api\V1\ApiVideoController::class, 'videoDetail'])->name('Api.get.video.detail');

    Route::get('/video-category/list', [\App\Http\Controllers\Api\V1\ApiCategoryController::class, 'categoryList'])->name('Api.get.category.list');
    Route::get('/video-category/{id}', [\App\Http\Controllers\Api\V1\ApiCategoryController::class, 'categoryDetail'])->name('Api.get.category.detail');

    Route::get('/video-grammar/list', [\App\Http\Controllers\Api\V1\ApiCategoryController::class, 'grammarList'])->name('Api.get.grammar.list');

    Route::get('/question/list', [\App\Http\Controllers\Api\V1\ApiQuestionController::class, 'questionList'])->name('Api.get.question.list');
    Route::get('/question/{id}', [\App\Http\Controllers\Api\V1\ApiQuestionController::class, 'questionDetail'])->name('Api.get.question.detail');

});
/* END API Version 1 */

/*  API Versions 2 */
Route::prefix('/v2')->name('apiV2.')->group(function () {
    Route::get('/get-books', [\App\Http\Controllers\Api\V2\EnglishApiController::class, 'getBooks'])->name('Api.get.books');

});
/* END API Version 2 */
