<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable
{
    use HasFactory, Notifiable;

    const TIPO_COMUM = 1;
    const TIPO_LOJISTA = 2;


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

    protected $casts = ['password' => 'hashed',];

    public function podeTransferir() : bool
    {
        /**
         * o único tipo que pode transferir dinheiro
         * é o tipo 1, o tipo comum
         */
        return $this->tipo_usuario_id == self::TIPO_COMUM;

    }

    /*
     * retornará True
     * Se o usuario tiver saldo suficiente para sacar o dinheiro
     */
    public function transferir(Float $valor) : void
    {
        $this->validaTransferencia($valor);
        $this->saldo -= $valor;
    }

    public function receber(Float $valor) : void
    {
        $this->saldo += $valor;
    }

    /**
     * @param  $valor
     * @return void
     * @throws Exception
     */
    public function validaTransferencia(Float $valor): void
    {
        if (!$this->podeTransferir()) {
            throw new Exception("Apenas usuários comuns podem realizar transfêrencias");
        }
        if ($valor < 0) {
            throw new Exception("Valor inválido para realizar a transação");
        }
        if ($this->saldo - $valor < 0) {
            throw new Exception("Saldo insuficiente para transfêrencia");
        }
    }


}
