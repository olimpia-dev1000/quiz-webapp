<?php

use App\Http\Controllers\AnswerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\QuizController;
use Illuminate\Support\Facades\Route;


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

    Route::get('/quizzes', [QuizController::class, 'index'])->name('quizzes');
    Route::post('/quizzes', [QuizController::class, 'store'])->name('quizzes.store');
    Route::get('/quizzes/create', [QuizController::class, 'create'])->name('quizzes.create');
    Route::get('/quizzes/{quiz}', [QuizController::class, 'show']);
    Route::get('/quizzes/{quiz}', [QuizController::class, 'edit'])->name('quizzes.edit');
    Route::patch('/quizzes/{quiz}', [QuizController::class, 'update'])->name('quizzes.update');
    Route::delete('/quizzes/{quiz}', [QuizController::class, 'destroy'])->name('quizzes.destroy');

    Route::post('/quizzes/{quiz}/questions', [QuestionController::class, 'store'])->name('questions.store');
    Route::get('/quizzes/{quiz}/questions', [QuestionController::class, 'index'])->name('questions');
    Route::patch('/quizzes/{quiz}/questions/{question}', [QuestionController::class, 'update'])->name('questions.update');
    Route::delete('/quizzes/{quiz}/questions/{question}', [QuestionController::class, 'destroy'])->name('questions.destroy');
    Route::post('/quizzes/{quiz}/questions/reorder', [QuestionController::class, 'reorder'])->name('questions.reorder');

    Route::get('/quizzes/{quiz}/questions/{question}/answers', [AnswerController::class, 'create'])->name('answers');
    Route::get('/quizzes/{quiz}/questions/{question}/answers/create', [AnswerController::class, 'create'])->name('answers.create');
    Route::post('/quizzes/{quiz}/questions/{question}/answers', [AnswerController::class, 'store'])->name('answers.store');
    Route::get('/quizzes/{quiz}/questions/{question}/answers/{answer}/edit', [AnswerController::class, 'edit'])->name('answers.edit');
    Route::patch('/quizzes/{quiz}/questions/{question}/answers/{answer}', [AnswerController::class, 'update'])->name('answers.update');
    Route::delete('/quizzes/{quiz}/questions/{question}/answers/{answer}', [AnswerController::class, 'destroy'])->name('answers.destroy');
});

require __DIR__ . '/auth.php';
