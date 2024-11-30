<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Http\Requests\MovieRequest;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    /**
     * Получить список всех фильмов
     */
    public function index() {
        $movies = Movie::with(['genres', 'actors', 'studio', 'ageRating', 'rating'])->get();
        return response()->json($movies, 200);
    }

    /**
     * Показать конкретный фильм
     */
    public function show($id) {
        $movie = Movie::with(['genres', 'actors', 'studio', 'ageRating', 'rating'])->find($id);

        return $movie
            ? response()->json($movie, 200)
            : response()->json(['message' => 'Фильм не найден'], 404);
    }

    /**
     * Создать новый фильм
     */
    public function store(MovieRequest $request) {
        $data = $request->validated();

        // Загрузка изображения, если предоставлено
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('movies', 'public');
        }

        $movie = Movie::create($data);

        // Связь с жанрами и актерами
        if ($request->has('genres')) {
            $movie->genres()->attach($request->input('genres'));
        }

        if ($request->has('actors')) {
            $movie->actors()->attach($request->input('actors'));
        }

        return response()->json(['message' => 'Фильм успешно добавлен', 'movie' => $movie], 201);
    }

    /**
     * Обновить существующий фильм
     */
    public function update(MovieRequest $request, $id) {
        $movie = Movie::find($id);

        if (!$movie) {
            return response()->json(['message' => 'Фильм не найден'], 404);
        }

        $data = $request->validated();

        // Загрузка нового изображения, если предоставлено
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('movies', 'public');
        }

        $movie->update($data);

        // Обновление связей с жанрами и актерами
        if ($request->has('genres')) {
            $movie->genres()->sync($request->input('genres'));
        }

        if ($request->has('actors')) {
            $movie->actors()->sync($request->input('actors'));
        }

        return response()->json(['message' => 'Фильм успешно обновлен', 'movie' => $movie], 200);
    }

    /**
     * Удалить фильм
     */
    public function destroy($id) {
        $movie = Movie::find($id);

        if (!$movie) {
            return response()->json(['message' => 'Фильм не найден'], 404);
        }

        $movie->delete();
        return response()->json(['message' => 'Фильм успешно удален'], 200);
    }
}
