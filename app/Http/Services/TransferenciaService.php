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
                "status" => false,
                "mensagem" => "A transfêrencia não foi autorizada"
            ];
        }
    }

    private function obterAutorizacao ()
    {
        $status = AutorizacaoService::obterAutorizacao();
        if ($status['message'] == "Autorizado") {
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
                "status" => false,
                 "mensagem" => $e->getMessage()
            ];
        }
        return [
            "status" => true,
            "mensagem" => "A Transfêrencia foi realizada com sucesso"
        ];
    }
}
