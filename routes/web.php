<?php

declare(strict_types=1);

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('', [HomeController::class, 'index'])->name('home');

Route::prefix('categories/')->controller(CategoryController::class)->group(function(): void {
    Route::get('', 'all')->name('categories.all');
    Route::delete('{id}', 'delete')->name('categories.delete');
    Route::put('{id}', 'edit')->name('categories.edit');
    Route::post('{parentId}', 'create')->name('categories.create');
});

Route::prefix('files/')->controller(FileController::class)->group(function(): void {
    Route::get('', 'all')->name('files.all');
    Route::post('{categoryId}', 'upload')->name('files.upload');
    Route::get('categories/{categoryId}', 'getByCategory')->name('files.by-category');
    Route::get('{id}', 'getById')->name('files.get');
});
