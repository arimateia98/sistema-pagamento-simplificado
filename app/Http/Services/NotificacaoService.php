<?php

namespace App\Http\Services;

use App\Models\Usuario;
use Illuminate\Support\Facades\Http;

class NotificacaoService
{


    public static function enviarNotificacao ($idTransferidor, $idReceptor, $valor) : void
    {
        $usuarioTransferidor = Usuario::find($idTransferidor);
        $usuarioReceptor = Usuario::find($idReceptor);

        $mensagemEnvio = self::getMensagemEnvio($usuarioReceptor, $valor);
        $mensagemRecebimento = self::getMensagemRecebimento($usuarioTransferidor, $valor);

        self::enviaEmail($usuarioTransferidor->email, $mensagemEnvio);
        self::enviaEmail($usuarioReceptor->email,$mensagemRecebimento);


    }

    /**
     * Monta mensagem de de envio de transferencia  para o email
     */
    public static function getMensagemEnvio($usuarioReceptor, $valor): string
    {
        $mensagemEnvio = "Você enviou uma transfêrencia para $usuarioReceptor->nome de valor R$: $valor";
        return $mensagemEnvio;
    }

    private static function getMensagemRecebimento($usuarioTransferidor, $valor)
    {
        $mensagemRecebimento = "Você recebeu uma transfêrencia de $usuarioTransferidor->nome de valor R$: $valor";
        return $mensagemRecebimento;
    }

    /**
     * @param $emailUsuario
     * @param string $mensagemEnvio
     * @return array|mixed|void
     */
    public static function enviaEmail(string $emailUsuario, string $mensagemEnvio): mixed
    {
        try {
            // Fazendo uma requisição POST para a API externa
            $response = Http::post('https://run.mocky.io/v3/54dc2cf1-3add-45b5-b5a9-6bf7e7f1f4a6', [
                'email' => $emailUsuario,
                'mensagem' => $mensagemEnvio
            ]);

            // Verificando se a requisição foi bem-sucedida
            if ($response->successful()) {
                return $response->json();
            }
        } catch (Exception $e) {
            // Lidando com exceções
            throw new Exception('Erro ao enviar Notificação: ' . $e->getMessage());
        }
    }

}
