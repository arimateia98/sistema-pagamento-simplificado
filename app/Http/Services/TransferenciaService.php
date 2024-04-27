<?php

namespace App\Http\Services;

use App\Models\Usuario;

class TransferenciaService
{

    public function transferir ($idTransferidor, $idReceptor, $valor) : bool
    {
        $usuarioTransferidor = Usuario::find($idTransferidor);
        $usuarioReceptor = Usuario::find($idReceptor);


        return true;
    }
}
