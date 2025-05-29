<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatController;
use Illuminate\Support\Facades\Route;


Route::get('/', [AuthController::class, 'loginPage'])->name('home');
Route::post('', [AuthController::class, 'loginProcess'])->name('loginProcess');

Route::resource('/chats', ChatController::class)->middleware('auth');