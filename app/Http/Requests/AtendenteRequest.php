<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class AtendenteRequest extends FormRequest
{
    /**
     * Determina se o usuário está autorizado a fazer essa solicitação.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Define as regras de validação.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id_usuario' => 'required|exists:usuarios,id|unique:atendentes,id_usuario',
        ];
    }

    /**
     * Define mensagens personalizadas para erros de validação.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'id_usuario.required' => 'O campo ID do usuário é obrigatório.',
            'id_usuario.exists' => 'O usuário informado não existe.',
            'id_usuario.unique' => 'Este usuário já está associado a um atendente.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        // Personaliza a resposta JSON em caso de erro de validação
        throw new HttpResponseException(response()->json([
            'message' => 'Os dados fornecidos são inválidos.',
            'errors' => $validator->errors()
        ], 422));
    }
}

