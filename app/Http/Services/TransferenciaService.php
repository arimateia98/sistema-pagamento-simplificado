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

        DB::beginTransaction();
        try {
            $usuarioTransferidor->transferir($valor);
            $usuarioReceptor->receber($valor);
            $usuarioTransferidor->save();
            $usuarioReceptor->save();
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
        return "A Transfêrencia foi realizada com sucesso";
    }
}
