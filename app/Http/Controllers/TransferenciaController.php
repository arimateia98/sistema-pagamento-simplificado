<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\TransferenciaRequest;
use App\Http\Services\TransferenciaService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TransferenciaController extends Controller
{
    protected TransferenciaService $service;

    public function __construct(TransferenciaService $transferenciaService)
    {
        $this->service = $transferenciaService;
    }
    public function transferir (TransferenciaRequest $request) : JsonResponse
    {

        return new JsonResponse(
            $this->service->transferir(
                $request->id_transferidor,
                $request->id_receptor,
                $request->valor_transferencia),
            200);

    }
}
