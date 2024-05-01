<?php

namespace App\Http\Services;

use App\Models\Usuario;

class UsuarioService
{
    public function store($usuario): bool
    {
        $novoUsuario = new Usuario();
        $novoUsuario->nome = $usuario->nome;
        $novoUsuario->email = $usuario->email;
        $novoUsuario->documento = $usuario->documento;
        $novoUsuario->tipo_usuario_id = $usuario->tipo_usuario_id;
        $novoUsuario->saldo = $usuario->saldo;
        $novoUsuario->senha = bcrypt($usuario->senha);
        return $novoUsuario->save();
    }

    public function get()
    {
        return Usuario::all();
    }

    public function destroyAll()
    {
        return Usuario::truncate();
    }
}
