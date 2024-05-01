<?php

namespace App\Http\Services;

use App\Models\Usuario;

/**
 * Classe responsável por lidar com operações relacionadas a usuários.
 */
class UsuarioService
{
    /**
     * Armazena um novo usuário no banco de dados.
     *
     * @param object $usuario Os dados do usuário a serem armazenados.
     * @return bool Retorna true se o usuário for armazenado com sucesso, false caso contrário.
     */
    public function store(object $usuario): bool
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

    /**
     * Obtém todos os usuários do banco de dados.
     *
     * @return \Illuminate\Database\Eloquent\Collection Uma coleção contendo todos os usuários.
     */
    public function get()
    {
        return Usuario::all();
    }

    /**
     * Exclui todos os usuários do banco de dados.
     *
     * @return void
     */
    public function destroyAll(): void
    {
        Usuario::truncate();
    }
}
