<?php

namespace App\Http\Services;

use App\Models\Usuario;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class TransferenciaService
{

    public function transferir ($idTransferidor, $idReceptor, $valor)
    {
        $usuarioTransferidor = Usuario::find($idTransferidor);
        $usuarioReceptor = Usuario::find($idReceptor);


        if ($this->obterAutorizacao()){
            return $this->realizarTransferencia($usuarioTransferidor,$usuarioReceptor,$valor);
        } else {
            return [
                "retorno" => false,
                "mensagem" => "A transfêrencia não foi autorizada"
            ];
        }
    }

    private function obterAutorizacao ()
    {
        $resposta = AutorizacaoService::obterAutorizacao();
        if ($resposta['message'] == "Autorizado") {
            return true;
        }
        return false;
    }

    /**
     * @param $usuarioTransferidor
     * @param $valor
     * @param $usuarioReceptor
     * @return string
     */
    public function realizarTransferencia(Usuario $usuarioTransferidor, Usuario $usuarioReceptor, Float $valor ): array
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
                "resposta" => false,
                 $e->getMessage()
            ];
        }
        return [
            "resposta" => true,
            "mensagem" => "A Transfêrencia foi realizada com sucesso"
        ];
    }
}
