<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\TransferenciaRequest;
use App\Http\Services\NotificacaoService;
use App\Http\Services\TransferenciaService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Controlador responsável por lidar com as operações relacionadas a transferências.
 */
class TransferenciaController extends Controller
{
    protected TransferenciaService $service;

    /**
     * @param TransferenciaService $transferenciaService injeção de dependência do service necessário
     */
    public function __construct(TransferenciaService $transferenciaService)
    {
        $this->service = $transferenciaService;
    }

    /**
     * Realiza uma transferência entre dois usuários.
     *
     * @param TransferenciaRequest $request A requisição contendo os dados da transferência.
     * @return JsonResponse A resposta JSON indicando o resultado da operação.
     */
    public function transferir(TransferenciaRequest $request): JsonResponse
    {

        $resposta = $this->service->transferir(
            $request->id_transferidor,
            $request->id_receptor,
            $request->valor_transferencia
        );

        $status = 400;
        /**
         * se o status do service for true
         * envia notificacao para os usuarios da transferência
         */
        if ($resposta['status']) {
            $status = 200;
            NotificacaoService::enviarNotificacao(
                $request->id_transferidor,
                $request->id_receptor,
                $request->valor_transferencia
            );
        }

        return new JsonResponse(
            ["resposta" => $resposta['mensagem']],
            $status
        );
    }
}
