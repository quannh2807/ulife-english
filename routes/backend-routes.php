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
        Route::get('/list', [\App\Http\Controllers\Backend\CategoryController::class, 'index'])->name('index');
        Route::get('/search', [\App\Http\Controllers\Backend\CategoryController::class, 'search'])->name('search');
        Route::get('/create', [\App\Http\Controllers\Backend\CategoryController::class, 'create'])->name('create');
        Route::post('/save-create', [\App\Http\Controllers\Backend\CategoryController::class, 'saveCreate'])->name('saveCreate');
        Route::get('/update/{id}', [\App\Http\Controllers\Backend\CategoryController::class, 'update'])->name('update');
        Route::post('/save-update', [\App\Http\Controllers\Backend\CategoryController::class, 'saveUpdate'])->name('saveUpdate');
        Route::get('/remove/{id}', [\App\Http\Controllers\Backend\CategoryController::class, 'remove'])->name('remove');
    });

    Route::prefix('video')->name('video.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Backend\VideoController::class, 'index'])->name('index');
        Route::get('/list', [\App\Http\Controllers\Backend\VideoController::class, 'index'])->name('index');
        Route::get('/create', [\App\Http\Controllers\Backend\VideoController::class, 'create'])->name('create');
        Route::post('/save-create', [\App\Http\Controllers\Backend\VideoController::class, 'saveCreate'])->name('saveCreate');
        Route::get('/update/{id}', [\App\Http\Controllers\Backend\VideoController::class, 'update'])->name('update');
        Route::post('/save-update', [\App\Http\Controllers\Backend\VideoController::class, 'saveUpdate'])->name('saveUpdate');
        Route::get('/remove/{id}', [\App\Http\Controllers\Backend\VideoController::class, 'remove'])->name('remove');
        Route::get('/search', [\App\Http\Controllers\Backend\VideoController::class, 'search'])->name('search');

        Route::prefix('/import')->group(function () {
            Route::get('/', [\App\Http\Controllers\Backend\VideoSubtitleController::class, 'import'])->name('importSub');
            Route::post('/upload', [\App\Http\Controllers\Backend\VideoSubtitleController::class, 'upload'])->name('uploadSub');
            Route::post('/preview', [\App\Http\Controllers\Backend\VideoSubtitleController::class, 'preview'])->name('preview');
            Route::post('/save-subtitle', [\App\Http\Controllers\Backend\VideoSubtitleController::class, 'saveUpload'])->name('saveSub');
        });
    });

    Route::prefix('subtitle')->name('subtitle.')->group(function () {
        Route::get('/refresh-sub/{video_id}', [\App\Http\Controllers\Backend\VideoSubtitleController::class, 'refresh'])->name('refresh');
        Route::get('/{video_id}', [\App\Http\Controllers\Backend\VideoSubtitleController::class, 'index'])->name('index');
        Route::post('/store', [\App\Http\Controllers\Backend\VideoSubtitleController::class, 'store'])->name('store');
        Route::get('/show/{sub_id}', [\App\Http\Controllers\Backend\VideoSubtitleController::class, 'show'])->name('show');
        Route::post('preview-sub', [\App\Http\Controllers\Backend\VideoSubtitleController::class, 'preview'])->name('previewSub');
        Route::get('/remove/{id}', [\App\Http\Controllers\Backend\VideoSubtitleController::class, 'destroy'])->name('destroy');
        Route::post('remove-all', [\App\Http\Controllers\Backend\VideoSubtitleController::class, 'destroyAll'])->name('destroyAll');
    });

    Route::prefix('question')->name('question.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Backend\QuestionController::class, 'index'])->name('index');
        Route::get('/list', [\App\Http\Controllers\Backend\QuestionController::class, 'index'])->name('index');
        Route::get('/search', [\App\Http\Controllers\Backend\QuestionController::class, 'search'])->name('search');
        Route::get('/getVideos', [\App\Http\Controllers\Backend\QuestionController::class, 'getVideos'])->name('getVideos');
        Route::get('/create', [\App\Http\Controllers\Backend\QuestionController::class, 'create'])->name('create');
        Route::post('/store', [\App\Http\Controllers\Backend\QuestionController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [\App\Http\Controllers\Backend\QuestionController::class, 'edit'])->name('edit');
        Route::post('/update', [\App\Http\Controllers\Backend\QuestionController::class, 'update'])->name('update');
        Route::get('/remove/{id}', [\App\Http\Controllers\Backend\QuestionController::class, 'remove'])->name('remove');
        Route::get('/ajax/detail', [\App\Http\Controllers\Backend\QuestionController::class, 'detail'])->name('detail');
        Route::get('/question-list/{id}/create', [\App\Http\Controllers\Backend\QuestionController::class, 'createQuestionList'])->name('createQuestionList');
        Route::get('/question-list/{id}/edit', [\App\Http\Controllers\Backend\QuestionController::class, 'editQuestionList'])->name('editQuestionList');
        Route::post('/question-list/{id}/store', [\App\Http\Controllers\Backend\QuestionController::class, 'storeQuestionList'])->name('storeQuestionList');
        Route::post('/question-list/{id}/update', [\App\Http\Controllers\Backend\QuestionController::class, 'updateQuestionList'])->name('updateQuestionList');
        Route::get('/question-list/remove/{id}', [\App\Http\Controllers\Backend\QuestionController::class, 'removeQuestionList'])->name('removeQuestionList');
    });

    Route::prefix('level')->name('level.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Backend\LevelsController::class, 'index'])->name('index');
        Route::get('/list', [\App\Http\Controllers\Backend\LevelsController::class, 'index'])->name('index');
        Route::get('/search', [\App\Http\Controllers\Backend\LevelsController::class, 'search'])->name('search');
        Route::get('/create', [\App\Http\Controllers\Backend\LevelsController::class, 'create'])->name('create');
        Route::post('/store', [\App\Http\Controllers\Backend\LevelsController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [\App\Http\Controllers\Backend\LevelsController::class, 'edit'])->name('edit');
        Route::post('/update', [\App\Http\Controllers\Backend\LevelsController::class, 'update'])->name('update');
        Route::get('/remove/{id}', [\App\Http\Controllers\Backend\LevelsController::class, 'remove'])->name('remove');
        Route::get('/ajax/detail', [\App\Http\Controllers\Backend\LevelsController::class, 'detail'])->name('detail');
    });

    Route::prefix('topics')->name('topics.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Backend\TopicsController::class, 'index'])->name('index');
        Route::get('/list', [\App\Http\Controllers\Backend\TopicsController::class, 'index'])->name('index');
        Route::get('/search', [\App\Http\Controllers\Backend\TopicsController::class, 'search'])->name('search');
        Route::get('/create', [\App\Http\Controllers\Backend\TopicsController::class, 'create'])->name('create');
        Route::post('/store', [\App\Http\Controllers\Backend\TopicsController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [\App\Http\Controllers\Backend\TopicsController::class, 'edit'])->name('edit');
        Route::post('/update', [\App\Http\Controllers\Backend\TopicsController::class, 'update'])->name('update');
        Route::get('/remove/{id}', [\App\Http\Controllers\Backend\TopicsController::class, 'remove'])->name('remove');
        Route::get('/ajax/detail', [\App\Http\Controllers\Backend\TopicsController::class, 'detail'])->name('detail');
    });

    Route::prefix('lesson')->name('lesson.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Backend\LessonController::class, 'index'])->name('index');
        Route::get('/list', [\App\Http\Controllers\Backend\LessonController::class, 'index'])->name('index');
        Route::get('/search', [\App\Http\Controllers\Backend\LessonController::class, 'search'])->name('search');
        Route::get('/create', [\App\Http\Controllers\Backend\LessonController::class, 'create'])->name('create');
        Route::post('/store', [\App\Http\Controllers\Backend\LessonController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [\App\Http\Controllers\Backend\LessonController::class, 'edit'])->name('edit');
        Route::post('/update', [\App\Http\Controllers\Backend\LessonController::class, 'update'])->name('update');
        Route::get('/remove/{id}', [\App\Http\Controllers\Backend\LessonController::class, 'destroy'])->name('remove');
        Route::get('/videos', [\App\Http\Controllers\Backend\LessonController::class, 'getVideos'])->name('getVideos');
        Route::get('/refresh-lesson-training', [\App\Http\Controllers\Backend\LessonController::class, 'refreshLessonTraining'])->name('refreshLessonTraining');
    });

    Route::prefix('vocabulary')->name('vocabulary.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Backend\VocabularyController::class, 'index'])->name('index');
        Route::get('/list', [\App\Http\Controllers\Backend\VocabularyController::class, 'index'])->name('index');
        Route::get('/search', [\App\Http\Controllers\Backend\VocabularyController::class, 'search'])->name('search');
        Route::get('/create', [\App\Http\Controllers\Backend\VocabularyController::class, 'create'])->name('create');
        Route::post('/store', [\App\Http\Controllers\Backend\VocabularyController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [\App\Http\Controllers\Backend\VocabularyController::class, 'edit'])->name('edit');
        Route::post('/update', [\App\Http\Controllers\Backend\VocabularyController::class, 'update'])->name('update');
        Route::get('/remove/{id}', [\App\Http\Controllers\Backend\VocabularyController::class, 'remove'])->name('remove');
        Route::get('/ajax/detail', [\App\Http\Controllers\Backend\VocabularyController::class, 'detail'])->name('detail');
        Route::get('/category/{catId}/list', [\App\Http\Controllers\Backend\VocabularyController::class, 'categoryList'])->name('categoryList');
        Route::get('/category/{catId}/create', [\App\Http\Controllers\Backend\VocabularyController::class, 'categoryCreate'])->name('categoryCreate');
        Route::get('/category/{catId}/update/{id}', [\App\Http\Controllers\Backend\VocabularyController::class, 'categoryEdit'])->name('categoryEdit');
        Route::post('/category-store', [\App\Http\Controllers\Backend\VocabularyController::class, 'categoryStore'])->name('categoryStore');
        Route::post('/category-update/{catId}', [\App\Http\Controllers\Backend\VocabularyController::class, 'categoryUpdate'])->name('categoryUpdate');
        Route::get('/category-search/{catId}', [\App\Http\Controllers\Backend\VocabularyController::class, 'categorySearch'])->name('categorySearch');
    });

    Route::prefix('vocabulary-cat')->name('vocabularyCat.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Backend\VocabularyCatController::class, 'index'])->name('index');
        Route::get('/list', [\App\Http\Controllers\Backend\VocabularyCatController::class, 'index'])->name('index');
        Route::get('/search', [\App\Http\Controllers\Backend\VocabularyCatController::class, 'search'])->name('search');
        Route::get('/create', [\App\Http\Controllers\Backend\VocabularyCatController::class, 'create'])->name('create');
        Route::post('/store', [\App\Http\Controllers\Backend\VocabularyCatController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [\App\Http\Controllers\Backend\VocabularyCatController::class, 'edit'])->name('edit');
        Route::post('/update', [\App\Http\Controllers\Backend\VocabularyCatController::class, 'update'])->name('update');
        Route::get('/remove/{id}', [\App\Http\Controllers\Backend\VocabularyCatController::class, 'remove'])->name('remove');
        Route::get('/ajax/detail', [\App\Http\Controllers\Backend\VocabularyCatController::class, 'detail'])->name('detail');
    });

    Route::prefix('lesson-training')->name('lessonTraining.')->group(function () {

    });
});
