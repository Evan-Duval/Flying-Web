<?php

namespace App\Http\Controllers;

use App\Models\Aeroport;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class AeroportController extends Controller
{
    public function getAll(): JsonResponse {
        $aeroports = Aeroport::all();
        return response()->json($aeroports, 200);
    }

    public function getById(int $id): JsonResponse {
        $aeroport = Aeroport::find($id);
        if (!$aeroport) {
            return response()->json(['message' => 'Aucun aeroport trouve !'], 404);
        } else {
            return response()->json($aeroport, 200);
        }      
    }

    public function create(Request $request): JsonResponse { 
        $aeroport = Aeroport::create($request->all());
        return response()->json($aeroport); 
    }

    public function update(Request $request, int $id): JsonResponse { 
        $aeroport = Aeroport::find($id);
        $aeroport->update($request->all());
        return response()->json($aeroport, 202); 
    }
    
    public function delete(int $id): JsonResponse {
        $aeroport = Aeroport::find($id);
        $aeroport->delete();
        return response()->json(['message' => 'aeroport supprimée'], 204);
    }
}
