<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Services\UsuarioService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\StoreUsuarioRequest;

class UsuarioController extends Controller
{
    protected UsuarioService $service;

    public function __construct(UsuarioService $usuarioService)
    {
        $this->service = $usuarioService;
    }


    public function store(StoreUsuarioRequest $request): JsonResponse
    {
        return new JsonResponse($this->service->store($request), 200);
    }

    public function get(): JsonResponse
    {
        return new JsonResponse($this->service->get(), 200);
    }

    public function destroyAll(): JsonResponse
    {
        return new JsonResponse($this->service->destroyAll(), 200);
    }
}
