<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\QuestionOptionController;
use App\Http\Controllers\ResponseAnswerController;
use App\Http\Controllers\SurveyController;
use Illuminate\Support\Facades\Route;


Route::get('/surveys/export/{id}', [SurveyController::class, 'export'])->name('surveys.export');

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');

})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::resource('surveys', SurveyController::class);
    Route::get('/surveys/{id}', [SurveyController::class, 'show'])->name('surveys.show');
    Route::resource('questions', QuestionController::class);
    Route::resource('response-answers', ResponseAnswerController::class);
    Route::resource('question-options', QuestionOptionController::class);
});

// Rota pública para visualização da pesquisa
Route::get('/surveys/slug/{slug}', [SurveyController::class, 'showPublic'])->name('survey.public.show');
Route::get('/surveys/slug/{slug}/start', [SurveyController::class, 'startSurvey'])->name('survey.public.start');
Route::get('/surveys/slug/{slug}/question/{question_id}', [SurveyController::class, 'showQuestion'])->name('survey.public.answer');
Route::post('/surveys/slug/{slug}/question/{question_id}', [SurveyController::class, 'storeResponse'])->name('survey.public.storeResponse');
Route::get('/surveys/slug/{slug}/complete', [SurveyController::class, 'completeSurvey'])->name('survey.public.complete');





require __DIR__.'/auth.php';
