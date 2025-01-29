<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getAll(): JsonResponse {
        $aeroports = User::all();
        return response()->json($aeroports, 200);
    }

    public function getById(int $id): JsonResponse {
        $aeroport = User::find($id);
        if (!$aeroport) {
            return response()->json(['message' => 'Aucun utilisateur pour cet id trouvé !'], 404);
        } else {
            return response()->json($aeroport, 200);
        }      
    }
}