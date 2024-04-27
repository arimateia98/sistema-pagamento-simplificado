<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransferenciaRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'id_transferidor' => 'required|exists:usuarios,id',
            'id_receptor' => 'required|exists:usuarios,id',
            'valor_transferencia' => 'required|numeric|min:0',
        ];
    }
}
