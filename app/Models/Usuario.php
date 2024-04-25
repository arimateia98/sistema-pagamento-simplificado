<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $primaryKey = 'documento'; // Define o atributo 'documento' como chave primária

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


}