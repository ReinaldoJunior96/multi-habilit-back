<?php
namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class EnderecoRequest extends FormRequest
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
            'cep' => 'required|string|size:8',
            'logradouro' => 'nullable|required|string|max:255',
            'complemento' => 'nullable|string|max:255',
            'bairro' => 'required|string|max:100',
            'uf' => 'required|string|size:2',
            'id_usuario' => 'required',
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
            'cep.required' => 'O campo CEP é obrigatório.',
            'cep.size' => 'O CEP deve ter 8 caracteres.',
            'logradouro.required' => 'O logradouro é obrigatório.',
            'bairro.required' => 'O bairro é obrigatório.',
            'uf.required' => 'O campo UF é obrigatório.',
            'uf.size' => 'O campo UF deve ter 2 caracteres.',
            'id_user.required' => 'O ID do usuário é obrigatório.',
            'id_user.exists' => 'O usuário informado não existe.',
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
