<?php

namespace App\Http\Controllers;

use App\Models\GarageDoor;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GarageDoorController extends Controller
{
    public function show(int $id): JsonResponse
    {
        return response()->json(GarageDoor::findOrFail($id));
    }

    public function trigger(int $id): JsonResponse
    {
        $garageDoor = GarageDoor::findOrFail($id);
        $garageDoor->trigger();

    }
}
