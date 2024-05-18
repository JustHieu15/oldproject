<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\HomeController as AdminHomeController;
use App\Http\Controllers\Admin\ExamsController as AdminExamsController;
use App\Http\Controllers\Admin\SubjectsController as AdminSubjectsController;
use App\Http\Controllers\Admin\QuestionsController as AdminQuestionsController;
use App\Http\Controllers\Admin\UsersController as AdminUsersController;

use App\Http\Controllers\Client\HomeController as ClientHomeController;
use App\Http\Controllers\Client\ExamsController as ClientExamsController;
use App\Http\Controllers\Client\SubjectsController as ClientSubjectsController;
use App\Http\Controllers\Client\QuestionsController as ClientQuestionsController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::group(['middleware' => 'prevent-back-history'], function () {
    Auth::routes();

    Route::prefix('admin')->middleware(['auth', 'isAdmin'])->group(function () {

        Route::get('/', [AdminHomeController::class, 'index'])->name('admin.home');

        Route::get('/search', [AdminHomeController::class, 'search'])->name('admin.search');

        Route::group(['prefix' => 'exams'], function () {
            Route::get('/', [AdminExamsController::class, 'index'])->name('admin.exams');

            Route::get('/create', [AdminExamsController::class, 'create'])->name('admin.exams.create');

            Route::get('/createBySubject/{id}', [AdminExamsController::class, 'createBySubject'])->name('admin.exams.createBySubject');

            Route::post('/', [AdminExamsController::class, 'store'])->name('admin.exams.store');

            Route::post('/createBySubject/{id}', [AdminExamsController::class, 'storeBySubject'])->name('admin.exams.storeBySubject');

            Route::get('/{id}', [AdminExamsController::class, 'show'])->name('admin.exams.show');

            Route::get('/edit/{id}', [AdminExamsController::class, 'edit'])->name('admin.exams.edit');

            Route::put('/update', [AdminExamsController::class, 'update'])->name('admin.exams.update');

            Route::delete('/delete/{id}', [AdminExamsController::class, 'destroy'])->name('admin.exams.destroy');
        });

        Route::group(['prefix' => 'subjects'], function () {
            Route::get('/', [AdminSubjectsController::class, 'index'])->name('admin.subjects');

            Route::get('/create', [AdminSubjectsController::class, 'create'])->name('admin.subjects.create');

            Route::post('/', [AdminSubjectsController::class, 'store'])->name('admin.subjects.store');

            Route::get('/{id}', [AdminSubjectsController::class, 'show'])->name('admin.subjects.show');

            Route::get('/edit/{id}', [AdminSubjectsController::class, 'edit'])->name('admin.subjects.edit');

            Route::put('/update', [AdminSubjectsController::class, 'update'])->name('admin.subjects.update');

            Route::delete('/delete/{id}', [AdminSubjectsController::class, 'destroy'])->name('admin.subjects.destroy');
        });

        Route::group(['prefix' => 'questions'], function () {
            Route::get('/', [AdminQuestionsController::class, 'index'])->name('admin.questions');

            Route::get('/create', [AdminQuestionsController::class, 'create'])->name('admin.questions.create');

            Route::get('/createByExam/{id}', [AdminQuestionsController::class, 'createByExam'])->name('admin.questions.createByExam');

            Route::post('/', [AdminQuestionsController::class, 'store'])->name('admin.questions.store');

            Route::post('/createByExam/{id}', [AdminQuestionsController::class, 'storeByExam'])->name('admin.questions.storeByExam');

            Route::get('/{id}', [AdminQuestionsController::class, 'show'])->name('admin.questions.show');

            Route::get('/edit/{id}', [AdminQuestionsController::class, 'edit'])->name('admin.questions.edit');

            Route::get('/editByExam/{id}', [AdminQuestionsController::class, 'editByExam'])->name('admin.questions.editByExam');

            Route::put('/update', [AdminQuestionsController::class, 'update'])->name('admin.questions.update');

            Route::put('/updateByExam', [AdminQuestionsController::class, 'updateByExam'])->name('admin.questions.updateByExam');

            Route::delete('/delete/{id}', [AdminQuestionsController::class, 'destroy'])->name('admin.questions.destroy');

            Route::delete('/deleteByExam/{id}', [AdminQuestionsController::class, 'destroyByExam'])->name('admin.questions.destroyByExam');
        });

        Route::group(['prefix' => 'users'], function () {
            Route::get('/', [AdminUsersController::class, 'index'])->name('admin.users');

            Route::get('/create', [AdminUsersController::class, 'create'])->name('admin.users.create');

            Route::post('/', [AdminUsersController::class, 'store'])->name('admin.users.store');

            Route::get('/{id}', [AdminUsersController::class, 'show'])->name('admin.users.show');

            Route::get('/edit/{id}', [AdminUsersController::class, 'edit'])->name('admin.users.edit');

            Route::put('/update', [AdminUsersController::class, 'update'])->name('admin.users.update');

            Route::delete('/delete/{id}', [AdminUsersController::class, 'destroy'])->name('admin.users.destroy');
        });
    });

    Route::prefix('/')->group(function () {

        Route::get('/', [ClientHomeController::class, 'index'])->name('/');

        Route::prefix('subjects')->group(function () {
            Route::get('/', [ClientSubjectsController::class, 'index'])->name('subjects');

            Route::get('/{id}', [ClientSubjectsController::class, 'show'])->name('subjects.show');

            Route::middleware('auth')->post('/{id}', [ClientSubjectsController::class, 'registerSubject'])->name('subjects.register');

            Route::middleware('auth')->delete('/{id}', [ClientSubjectsController::class, 'unregisterSubject'])->name('subjects.unregister');
        });

        Route::prefix('questions')->group(function () {
            Route::get('/', [ClientQuestionsController::class, 'index'])->name('questions');

            Route::middleware('auth')->get('/{examId}/{userId}', [ClientQuestionsController::class, 'show'])->name('questions.show');

            Route::post('/{id}/point', [ClientQuestionsController::class, 'point'])->name('questions.point');

            Route::post('/complete/{examId}/{userId}', [ClientQuestionsController::class, 'completeExam'])->name('questions.complete');

            Route::get('/result/{examId}/{userId}', [ClientQuestionsController::class, 'result'])->name('questions.result');
        });
    });

    Route::fallback(function () {
        $response = response()->view('errors.404', [], 404);
        return $response;
    });
});
