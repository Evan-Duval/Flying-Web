<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ReservationController extends Controller
{
    public function getAll(): JsonResponse {
        $reservation = Reservation::all();
        return response()->json($reservation, 200);
    }

    public function getById(int $id): JsonResponse {
        $reservation = Reservation::find($id);
        if (!$reservation) {
            return response()->json(['message' => 'Aucune reservation trouve !'], 404);
        } else {
            return response()->json($reservation, 200);
        }      
    }

    public function create(Request $request): JsonResponse { 
        $reservation = Reservation::create($request->all());
        return response()->json($reservation); 
    }

    public function update(Request $request, int $id): JsonResponse { 
        $reservation = Reservation::find($id);
        $reservation->update($request->all());
        return response()->json($reservation, 202); 
    }
    
    public function delete(int $id): JsonResponse {
        $reservation = Reservation::find($id);
        $reservation->delete();
        return response()->json(['message' => 'Reservation supprimée'], 204);
    }
}
