<?php

use App\Http\Controllers\BatchController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


// Static Route
Route::get('/students', function(){
    return "Hello, students";
});

// Dynamic Route
Route::get('/students/{id}', function($id){
    return "Sudent ID : " . $id;
});

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


Route::get('/batches', [BatchController::class, 'index']);

Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
Route::post('/categories/store', [CategoryController::class, 'store'])->name('categories.store');

Route::get('/categories/{id}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
Route::post('/categories/{id}/update', [CategoryController::class, 'update'])->name('categories.update');

Route::post('/categories/{id}/delete', [CategoryController::class, 'delete'])->name('categories.delete');
