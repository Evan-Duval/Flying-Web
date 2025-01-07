<?php

namespace App\Http\Controllers;

use App\Models\Piste;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PisteController extends Controller
{
    public function getAll(): JsonResponse {
        $piste = Piste::all();
        return response()->json($piste, 200);
    }

    public function getById(int $id): JsonResponse {
        $piste = Piste::find($id);
        if (!$piste) {
            return response()->json(['message' => 'Aucune piste trouve !'], 404);
        } else {
            return response()->json($piste, 200);
        }      
    }

    public function create(Request $request): JsonResponse { 
        $piste = Piste::create($request->all());
        return response()->json($piste); 
    }

    public function update(Request $request, int $id): JsonResponse { 
        $piste = Piste::find($id);
        $piste->update($request->all());
        return response()->json($piste, 202); 
    }
    
    public function delete(int $id): JsonResponse {
        $piste = Piste::find($id);
        $piste->delete();
        return response()->json(['message' => 'Piste supprimée'], 204);
    }
}
