<?php

use App\Http\Controllers\BatchController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InstructorController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {

    // Batches
    Route::get('/batches', [BatchController::class, 'index'])->name('batches.index');
    Route::get('/batches/create', [BatchController::class, 'create'])->name('batches.create');
    Route::post('/batches/store', [BatchController::class, 'store'])->name('batches.store');

    Route::get('/batches/{id}/edit', [BatchController::class, 'edit'])->name('batches.edit');
    Route::post('/batches/{id}/update', [BatchController::class, 'update'])->name('batches.update');

    Route::post('/batches/{id}/delete', [BatchController::class, 'delete'])->name('batches.delete');


    // Category
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories/store', [CategoryController::class, 'store'])->name('categories.store');

    Route::get('/categories/{id}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::post('/categories/{id}/update', [CategoryController::class, 'update'])->name('categories.update');

    Route::post('/categories/{id}/delete', [CategoryController::class, 'delete'])->name('categories.delete');


    // Students
    Route::get('/students', [StudentController::class, 'index'])->name('students.index');
    Route::get('/students/create', [StudentController::class, 'create'])->name('students.create');
    Route::post('/students/store', [StudentController::class, 'store'])->name('students.store');

    Route::get('/students/{id}/edit', [StudentController::class, 'edit'])->name('students.edit');
    Route::post('/students/{id}/update', [StudentController::class, 'update'])->name('students.update');

    Route::post('/students/{id}/delete', [StudentController::class, 'delete'])->name('students.delete');


    // Instructor
    Route::get('/instructors', [InstructorController::class, 'index'])->name('instructors.index');
    Route::get('/instructors/create', [InstructorController::class, 'create'])->name('instructors.create');
    Route::post('/instructors/store', [InstructorController::class, 'store'])->name('instructors.store');

    Route::get('/instructors/{id}/edit', [InstructorController::class, 'edit'])->name('instructors.edit');
    Route::post('/instructors/{id}/update', [InstructorController::class, 'update'])->name('instructors.update');

    Route::post('/instructors/{id}/delete', [InstructorController::class, 'delete'])->name('instructors.delete');
});
