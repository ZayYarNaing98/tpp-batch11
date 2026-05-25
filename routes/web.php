<?php

use App\Http\Controllers\BatchController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/students', [StudentController::class, 'index'])->name('students.index');
Route::get('/students/create', [StudentController::class, 'create'])->name('students.create');
Route::post('/students/store', [StudentController::class, 'store'])->name('students.store');

Route::get('/students/{id}/edit', [StudentController::class, 'edit'])->name('students.edit');
Route::post('/students/{id}/update', [StudentController::class, 'update'])->name('students.update');

Route::post('/students/{id}/delete', [StudentController::class, 'delete'])->name('students.delete');

// Naming Route
Route::get('/dashboard', function(){
    return "Welcome from TPP Program";
})->name('tpp');


// Redirect Route
Route::get('/talent', function(){
    return redirect()->route('tpp');
});


// Group Route
Route::prefix('/backend')->group(function(){

    Route::get('/users', function(){
        return "This is backend user";
    });

    Route::get('/php-talent', function(){
        return redirect()->route('tpp');
    });

});


Route::get('/batches', [BatchController::class, 'index'])->name('batches.index');
Route::get('/batches/create', [BatchController::class, 'create'])->name('batches.create');
Route::post('/batches/store', [BatchController::class, 'store'])->name('batches.store');

Route::get('/batches/{id}/edit', [BatchController::class, 'edit'])->name('batches.edit');
Route::post('/batches/{id}/update', [BatchController::class, 'update'])->name('batches.update');

Route::post('/batches/{id}/delete', [BatchController::class, 'delete'])->name('batches.delete');

Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
Route::post('/categories/store', [CategoryController::class, 'store'])->name('categories.store');

Route::get('/categories/{id}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
Route::post('/categories/{id}/update', [CategoryController::class, 'update'])->name('categories.update');

Route::post('/categories/{id}/delete', [CategoryController::class, 'delete'])->name('categories.delete');
