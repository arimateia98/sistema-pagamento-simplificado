<?php

namespace App\Http\Services;

use App\Models\Usuario;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

/**
 * Classe responsável por realizar transferências entre usuários.
 */
class TransferenciaService
{
    /**
     * Realiza uma transferência entre dois usuários.
     *
     * @param int $idTransferidor O ID do usuário que está realizando a transferência.
     * @param int $idReceptor O ID do usuário que está recebendo a transferência.
     * @param float $valor O valor da transferência.
     * @return array O status da transferência e uma mensagem descritiva do que ocorreu.
     */
    public function transferir(int $idTransferidor, int $idReceptor, float $valor): array
    {
        $usuarioTransferidor = Usuario::find($idTransferidor);
        $usuarioReceptor = Usuario::find($idReceptor);

        if ($this->obterAutorizacao()) {
            return $this->realizarTransferencia($usuarioTransferidor, $usuarioReceptor, $valor);
        } else {
            return [
                "status" => false,
                "mensagem" => "A transferência não foi autorizada"
            ];
        }
    }

    /**
     * Obtém autorização para realizar a transferência.
     *
     * @return bool Retorna verdadeiro se a autorização for concedida, falso caso contrário.
     */
    private function obterAutorizacao(): bool
    {
        $status = AutorizacaoService::obterAutorizacao();
        return $status['message'] === "Autorizado";
    }

    /**
     * Realiza a transferência entre os usuários.
     *
     * @param Usuario $usuarioTransferidor O objeto de usuário que está realizando a transferência.
     * @param Usuario $usuarioReceptor O objeto de usuário que está recebendo a transferência.
     * @param float $valor O valor da transferência.
     * @return array O status da transferência e uma mensagem descritiva.
     */
    private function realizarTransferencia(Usuario $usuarioTransferidor, Usuario $usuarioReceptor, float $valor): array
    {
        DB::beginTransaction();
        try {
            $usuarioTransferidor->transferir($valor);
            $usuarioReceptor->receber($valor);
            $usuarioTransferidor->save();
            $usuarioReceptor->save();
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return [
                "status" => false,
                "mensagem" => $e->getMessage()
            ];
        }

        return [
            "status" => true,
            "mensagem" => "A transferência foi realizada com sucesso"
        ];
    }
}
