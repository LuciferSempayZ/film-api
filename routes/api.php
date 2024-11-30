<?php

use App\Http\Controllers\ActorController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\StudioController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    // Пользователи
    Route::get('/users', [UserController::class, 'index']); // Просмотр всех пользователей
    Route::get('/users/{id}', [UserController::class, 'show']); // Просмотр профиля пользователя
    Route::put('/users/{id}', [UserController::class, 'update']); // Редактирование
    Route::delete('/users/{id}', [UserController::class, 'destroy']); // Удаление

    // Фильмы
    Route::apiResource('/movies', MovieController::class);
    Route::post('/movies/{id}/favorite', [MovieController::class, 'addToFavorites']); // Добавление в избранное
    Route::get('/movies/favorites', [MovieController::class, 'favorites']); // Просмотр избранного
    Route::get('/movies', [MovieController::class, 'index']);
    Route::get('/movies/{id}', [MovieController::class, 'show']);
    Route::post('/movies', [MovieController::class, 'store']);
    Route::put('/movies/{id}', [MovieController::class, 'update']);
    Route::delete('/movies/{id}', [MovieController::class, 'destroy']);

    // Отзывы
    Route::get('/rating', [RatingController::class, 'index']);
    Route::get('/rating/{id}', [RatingController::class, 'show']);
    Route::post('/rating', [RatingController::class, 'store']);
    Route::put('/rating/{id}', [RatingController::class, 'update']);
    Route::delete('/rating/{id}', [RatingController::class, 'destroy']);

    // Актеры
    Route::apiResource('/actors', ActorController::class);
    Route::prefix('actors')->group(function () {
        Route::get('/actors', [ActorController::class, 'index']); // Публичный доступ
        Route::get('/actors/{id}', [ActorController::class, 'show']); // Публичный доступ
        Route::middleware('auth:sanctum')->post('actors', [ActorController::class, 'store']); // Добавление актера
        Route::middleware('auth:sanctum')->put('actors/{id}', [ActorController::class, 'update']); // Обновление актера
        Route::middleware('auth:sanctum')->delete('actors/{id}', [ActorController::class, 'destroy']); // Удаление актера
    });

    // Студии
    Route::apiResource('/studios', StudioController::class);
    Route::prefix('studios')->group(function () {
        Route::get('/', [StudioController::class, 'index']);          // Просмотр всех студий
        Route::get('/{id}', [StudioController::class, 'show']);       // Просмотр конкретной студии
        Route::post('/', [StudioController::class, 'store']);         // Добавление новой студии
        Route::put('/{id}', [StudioController::class, 'update']);     // Обновление информации о студии
        Route::delete('/{id}', [StudioController::class, 'destroy']); // Удаление студии
    });

    // Жанры
    Route::apiResource('/genres', GenreController::class);
    Route::get('/genres', [GenreController::class, 'index']);
    Route::get('/genres/{id}', [GenreController::class, 'show']);
    Route::post('/genres', [GenreController::class, 'store']);
    Route::put('/genres/{id}', [GenreController::class, 'update']);
    Route::delete('/genres/{id}', [GenreController::class, 'destroy']);
});
