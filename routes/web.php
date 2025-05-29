<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatController;
use Illuminate\Support\Facades\Route;


Route::get('/', [AuthController::class, 'loginPage'])->name('login');
Route::post('', [AuthController::class, 'loginProcess'])->name('loginProcess');


Route::middleware(['auth'])->group(function () {
    Route::get('/chat/{user}', [ChatController::class, 'viewChat'])->name('chat.view');
    Route::get('/chats', [ChatController::class, 'index']);
    Route::post('/chats', [ChatController::class, 'store']);
});
