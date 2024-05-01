<?php

namespace App\Http\Services;

use App\Models\Usuario;
use Exception;
use Illuminate\Support\Facades\Http;

/**
 * Classe responsável por enviar notificações de transferência para os usuários.
 */
class NotificacaoService
{
    /**
     * Envia notificação de transferência para o transferidor e receptor.
     *
     * @param int $idTransferidor O ID do usuário que está realizando a transferência.
     * @param int $idReceptor O ID do usuário que está recebendo a transferência.
     * @param float $valor O valor da transferência.
     * @return void
     * @throws Exception Quando ocorre um erro durante o envio da notificação.
     */
    public static function enviarNotificacao(int $idTransferidor, int $idReceptor, float $valor): void
    {
        $usuarioTransferidor = Usuario::find($idTransferidor);
        $usuarioReceptor = Usuario::find($idReceptor);

        $mensagemEnvio = self::getMensagemEnvio($usuarioReceptor, $valor);
        $mensagemRecebimento = self::getMensagemRecebimento($usuarioTransferidor, $valor);

        self::enviaEmail($usuarioTransferidor->email, $mensagemEnvio);
        self::enviaEmail($usuarioReceptor->email, $mensagemRecebimento);
    }

    /**
     * Gera mensagem de envio de transferência para o transferidor.
     *
     * @param Usuario $usuarioReceptor O objeto de usuário que está recebendo a transferência.
     * @param float $valor O valor da transferência.
     * @return string A mensagem de envio de transferência.
     */
    public static function getMensagemEnvio(Usuario $usuarioReceptor, float $valor): string
    {
        $mensagemEnvio = "Você enviou uma transferência para {$usuarioReceptor->nome} de valor R$: $valor";
        return $mensagemEnvio;
    }

    /**
     * Gera mensagem de recebimento de transferência para o receptor.
     *
     * @param Usuario $usuarioTransferidor O objeto de usuário que está realizando a transferência.
     * @param float $valor O valor da transferência.
     * @return string A mensagem de recebimento de transferência.
     */
    public static function getMensagemRecebimento(Usuario $usuarioTransferidor, float $valor): string
    {
        $mensagemRecebimento = "Você recebeu uma transferência de {$usuarioTransferidor->nome} de valor R$: $valor";
        return $mensagemRecebimento;
    }

    /**
     * Envia um email de notificação para o usuário.
     *
     * @param string $emailUsuario O endereço de e-mail do usuário.
     * @param string $mensagemEnvio A mensagem a ser enviada no e-mail.
     * @return array|mixed Os dados da resposta  em caso de sucesso.
     * @throws Exception Quando ocorre um erro durante o envio do e-mail.
     */
    public static function enviaEmail(string $emailUsuario, string $mensagemEnvio): mixed
    {
        try {
            $response = Http::post(
                'https://run.mocky.io/v3/54dc2cf1-3add-45b5-b5a9-6bf7e7f1f4a6',
                [
                    'email' => $emailUsuario,
                    'mensagem' => $mensagemEnvio
                ]
            );

            if ($response->successful()) {
                return $response->json();
            }
        } catch (Exception $e) {
            throw new Exception('Erro ao enviar Notificação: ' . $e->getMessage());
        }
    }
}
