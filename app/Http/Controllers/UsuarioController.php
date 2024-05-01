<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Services\UsuarioService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\StoreUsuarioRequest;

/**
 * Controlador responsável por lidar com as operações relacionadas a usuários.
 */
class UsuarioController extends Controller
{
    protected UsuarioService $service;

    /**
     * Cria uma nova instância do controlador.
     *
     * @param UsuarioService $usuarioService O serviço de usuário injetado.
     */
    public function __construct(UsuarioService $usuarioService)
    {
        $this->service = $usuarioService;
    }

    /**
     * Armazena um novo usuário.
     *
     * @param StoreUsuarioRequest $request A requisição contendo os dados do novo usuário.
     * @return JsonResponse A resposta JSON indicando o resultado da operação.
     */
    public function store(StoreUsuarioRequest $request): JsonResponse
    {
        return new JsonResponse($this->service->store($request), 200);
    }

    /**
     * Obtém todos os usuários.
     *
     * @return JsonResponse A resposta JSON contendo todos os usuários.
     */
    public function get(): JsonResponse
    {
        return new JsonResponse($this->service->get(), 200);
    }

    /**
     * Exclui todos os usuários.
     *
     * @return JsonResponse A resposta JSON indicando o resultado da operação.
     */
    public function destroyAll(): JsonResponse
    {
        return new JsonResponse($this->service->destroyAll(), 200);
    }
}
