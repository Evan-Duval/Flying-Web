<?php

namespace App\Http\Controllers;

use App\Models\Aeroport;
use App\Models\Plane;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PlaneController extends Controller
{
    public function getAll(): JsonResponse {
        $plane = Plane::all();
        return response()->json($plane, 200);
    }

    public function getById(int $id): JsonResponse {
        $plane = Plane::find($id);
        if (!$plane) {
            return response()->json(['message' => 'Aucun avion trouve !'], 404);
        } else {
            return response()->json($plane, 200);
        }      
    }

    public function getByAirport(int $id): JsonResponse {
        $airport = Aeroport::find($id);
        if (!$airport) {
            return response()->json(['message' => 'Aucun aeroport trouvé pour cet id !'], 404);
        } else {
            $pistes = Plane::where('aeroport_id', $id)->get();          
            return response()->json($pistes, 200);
        }
    }


    public function create(Request $request): JsonResponse { 
        $plane = Plane::create($request->all());
        return response()->json($plane); 
    }

    public function update(Request $request, int $id): JsonResponse { 
        $plane = Plane::find($id);
        $plane->update($request->all());
        return response()->json($plane, 202); 
    }
    
    public function delete(int $id): JsonResponse {
        $plane = Plane::find($id);
        $plane->delete();
        return response()->json(['message' => 'Avion supprimée'], 204);
    }
}
