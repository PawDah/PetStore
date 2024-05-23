<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;
Route::get('/api/create', [ApiController::class, 'create'])->name('api.create');
Route::get('/api/{status}', [ApiController::class, 'index'])->name('api.index');
Route::get('/api/{id}/edit', [ApiController::class, 'edit'])->name('api.edit');
Route::get('/api/{id}', [ApiController::class, 'update'])->name('api.update');
Route::post('/api/create', [ApiController::class, 'store'])->name('api.store');
Route::delete('/api/{id}', [ApiController::class, 'destroy'])->name('api.destroy');

Route::get('/',[PageController::class,'index']);
