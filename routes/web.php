<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;


Route::get('/', [AuthController::class,'loginPage'])->name('home');
Route::post('', [AuthController::class,'loginProcess'])->name('loginProcess');