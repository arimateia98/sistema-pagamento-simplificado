<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Classe de modelo que representa um usuário no sistema.
 */
class Usuario extends Authenticatable
{
    use HasFactory;
    use Notifiable;

    public const TIPO_COMUM = 1;
    public const TIPO_LOJISTA = 2;


    protected $fillable = [
        'nome',
        'email',
        'documento',
        'tipo_usuario_id',
        'saldo',
        'senha',
    ];


    protected $hidden = [
        'senha',
        'remember_token',
    ];


    protected $casts = [
        'password' => 'hashed',
    ];

    /**
     * Verifica se o usuário pode realizar transferências.
     * Apenas usuarios do tipo comum podem realizar transfêrencias
     *
     * @return bool Retorna true se o usuário puder transferir dinheiro, false caso contrário.
     */
    public function podeTransferir(): bool
    {
        /**
         * O único tipo que pode transferir dinheiro é o tipo 1, o tipo comum.
         */
        return $this->tipo_usuario_id == self::TIPO_COMUM;
    }

    /**
     * Realiza a transferência de saldo para outro usuário.
     *
     * @param float $valor O valor a ser transferido.
     * @return void
     * @throws Exception Se o usuário não puder transferir dinheiro, se o valor for negativo ou se o saldo for insuficiente.
     */
    public function transferir(float $valor): void
    {
        $this->validaTransferencia($valor);
        $this->saldo -= $valor;
    }

    /**
     * Adiciona saldo ao usuário.
     * Valor que vem de outro usuário
     *
     * @param float $valor O valor a ser adicionado ao saldo do usuário.
     * @return void
     */
    public function receber(float $valor): void
    {
        $this->saldo += $valor;
    }

    /**
     * Valida se a transfêrencia é válida
     *
     * @param float $valor O valor da transferência a ser validado.
     * @return void
     * @throws Exception Se o usuário não puder transferir dinheiro, se o valor for negativo ou se o saldo for insuficiente.
     */
    public function validaTransferencia(float $valor): void
    {
        if (!$this->podeTransferir()) {
            throw new Exception("Apenas usuários comuns podem realizar transferências");
        }
        if ($valor < 0) {
            throw new Exception("Valor inválido para realizar a transação");
        }
        if ($this->saldo - $valor < 0) {
            throw new Exception("Saldo insuficiente para transferência");
        }
    }
}
