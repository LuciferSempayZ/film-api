<?php

namespace App\Http\Controllers;

use App\Http\Requests\ActorRequest;  // Включаем запрос на валидацию
use App\Models\Actor;
use Illuminate\Http\Request;

class ActorController extends Controller
{
    // Получение списка всех актеров
    public function index()
    {
        $actors = Actor::all();
        return response()->json($actors);
    }

    // Получение информации о конкретном актере
    public function show($id)
    {
        $actor = Actor::find($id);

        if (!$actor) {
            return response()->json(['message' => 'Актер не найден.'], 404);
        }

        return response()->json($actor);
    }

    // Добавление нового актера
    public function store(ActorRequest $request)
    {
        $actor = Actor::create($request->validated());  // Валидация с помощью ActorRequest
        return response()->json(['message' => 'Актер успешно добавлен.', 'actor' => $actor], 201);
    }

    // Обновление информации об актере
    public function update(ActorRequest $request, $id)
    {
        $actor = Actor::find($id);

        if (!$actor) {
            return response()->json(['message' => 'Актер не найден.'], 404);
        }

        $actor->update($request->validated());
        return response()->json(['message' => 'Актер успешно обновлен.', 'actor' => $actor]);
    }

    // Удаление актера
    public function destroy($id)
    {
        $actor = Actor::find($id);

        if (!$actor) {
            return response()->json(['message' => 'Актер не найден.'], 404);
        }

        $actor->delete();
        return response()->json(['message' => 'Актер успешно удален.']);
    }
}
