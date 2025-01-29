<?php

namespace App\Http\Controllers;

use App\Models\Fly;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class FlyController extends Controller
{
    public function getAll(): JsonResponse {
        $fly = Fly::all();
        return response()->json($fly, 200);
    }

    public function getById(int $id): JsonResponse {
        $fly = Fly::find($id);
        if (!$fly) {
            return response()->json(['message' => 'Aucun vol trouve !'], 404);
        } else {
            return response()->json($fly, 200);
        }      
    }

    public function create(Request $request): JsonResponse { 
        $fly = Fly::create($request->all());
        return response()->json($fly); 
    }

    public function update(Request $request, int $id): JsonResponse { 
        $fly = Fly::find($id);
        $fly->update($request->all());
        return response()->json($fly, 202); 
    }
    
    public function delete(int $id): JsonResponse {
        $fly = Fly::find($id);
        $fly->delete();
        return response()->json(['message' => 'Vol supprimée'], 204);
    }
}
