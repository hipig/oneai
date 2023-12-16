<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('authorizations', [Api\AuthorizationsController::class, 'store'])->name('authorizations.store');

Route::middleware('auth:api')->group(function () {
    Route::get('user', [Api\AuthorizationsController::class, 'me'])->name('authorizations.me');
    Route::delete('authorizations', [Api\AuthorizationsController::class, 'destroy'])->name('authorizations.destroy');

    Route::get('models', [Api\ModelsController::class, 'index'])->name('models.index');

    Route::post('chats/{chat}/stream', [Api\ChatsController::class, 'stream'])->name('chats.stream');
    Route::post('chats/{chat}/clear', [Api\ChatsController::class, 'clear'])->name('chats.clear');
    Route::apiResource('chats', Api\ChatsController::class)->names('chats')->except('show');
    Route::apiResource('messages', Api\MessagesController::class)->names('messages')->only('index', 'store', 'destroy');

    Route::get('prompt-groups', [Api\PromptGroupsController::class, 'index'])->name('prompt-groups.index');
    Route::get('prompts/random', [Api\PromptsController::class, 'random'])->name('prompts.random');
});
