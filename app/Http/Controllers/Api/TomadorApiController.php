<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TomadorServico;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class TomadorApiController extends Controller
{
    public function indexApi(): JsonResponse
    {
        $tomadores = TomadorServico::orderBy('id', 'DESC')->paginate(40);

        return response()->json([
            'status' => true,
            'tomadores' => $tomadores
        ], 200);
    }

    public function storeApi(Request $request): JsonResponse
    {

        $tomador = TomadorServico::create($request->all());

        return response()->json([
            'status' => true,
            'tomador' => $tomador,
            'message' => 'Tomador de serviço criado com sucesso!'
        ], 201);
    }
}
