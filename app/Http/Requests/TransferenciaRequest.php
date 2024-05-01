<?php

namespace App\Http\Requests;

use Exception;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class TransferenciaRequest extends FormRequest
{
    /**
     * Manipula a falha na validação da solicitação.
     *
     * @param Validator $validator O validador que contém os erros de validação.
     * @return void
     * @throws HttpResponseException Em caso de falha na validação, uma exceção com a resposta JSON é lançada.
     */
    protected function failedValidation(Validator $validator)
    {
        $response = new JsonResponse(
            [
            'message' => 'Os dados fornecidos são inválidos.',
            'errors' => $validator->errors(),
            ],
            400
        );

        throw new HttpResponseException($response);
    }
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

    public function messages()
    {
        return [
            'id_transferidor.required' => 'O campo do transferidor é obrigatório.',
            'id_transferidor.exists' => 'O transferidor especificado não existe.',
            'id_receptor.required' => 'O campo do receptor é obrigatório.',
            'id_receptor.exists' => 'O receptor especificado não existe.',
            'valor_transferencia.required' => 'O campo do valor da transferência é obrigatório.',
            'valor_transferencia.numeric' => 'O campo do valor da transferência deve ser numérico.',
            'valor_transferencia.min' => 'O valor da transferência deve ser maior ou igual a zero.',
        ];
    }
}
