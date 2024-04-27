<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Services\UsuarioService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\StoreUsuarioRequest;


class UsuarioController extends Controller
{
    public function store(StoreUsuarioRequest $request) : JsonResponse
    {
        $service = new UsuarioService();
        return new JsonResponse($service->store($request), 200);
    }

}
