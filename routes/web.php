<?php


use App\Http\Controllers\PetController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () { return redirect('/pet'); });
Route::get('/pet', [PetController::class, 'index'])->name('pet.index');
Route::post('/pet', [PetController::class, 'store'])->name('pet.store');
Route::put('/pet/update-post', [PetController::class, 'update'])->name('pet.update-post');
Route::delete('/pet/destroy-post', [PetController::class, 'destroy'])->name('pet.destroy-post');
