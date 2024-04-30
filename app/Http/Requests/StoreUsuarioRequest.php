<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUsuarioRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'nome' => 'required|string|max:255',
            'email' => 'required|email|unique:usuarios,email',
            'documento' => 'required|unique:usuarios,documento',
            'tipo_usuario_id' => 'required|exists:tipos_usuario,id',
            'senha' => 'required|string|min:6',
        ];
    }


    public function messages(): array
    {
        return [
            'nome.required' => 'O campo nome é obrigatório.',
            'email.required' => 'O campo email é obrigatório.',
            'email.email' => 'Por favor, insira um endereço de email válido.',
            'email.unique' => 'Este endereço de email já está em uso.',
            'documento.required' => 'O campo documento é obrigatório.',
            'documento.unique' => 'Este documento já está em uso.',
            'tipo_usuario_id.required' => 'O campo tipo de usuário é obrigatório.',
            'tipo_usuario_id.exists' => 'O tipo de usuário selecionado é inválido.',
            'senha.required' => 'O campo senha é obrigatório.',
        ];
    }
}
