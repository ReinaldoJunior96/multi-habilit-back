<?php

namespace App\Http\Requests;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class MedicoRequest extends FormRequest
{
    /**
     * Determina se o usuário está autorizado a fazer essa solicitação.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // Permite que qualquer usuário faça a solicitação
    }

    /**
     * Define as regras de validação.
     *
     * @return array
     */
    public function rules()
    {
        $medicoId = $this->route('id');
        $usuarioId = $this->input('id_usuario');
        return [
            'regime_trabalhista' => 'required|integer',
            'carga_horaria' => 'required|integer|min:1|max:60',
            'cnpj' => 'required|string|size:14',
            'id_usuario' => 'required'
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
            'regime_trabalhista.required' => 'O regime trabalhista é obrigatório.',
            'regime_trabalhista.integer' => 'O regime trabalhista deve ser um número inteiro.',
            'carga_horaria.required' => 'A carga horária é obrigatória.',
            'carga_horaria.integer' => 'A carga horária deve ser um número inteiro.',
            'carga_horaria.min' => 'A carga horária mínima permitida é 1 hora.',
            'carga_horaria.max' => 'A carga horária máxima permitida é 60 horas.',
            'cnpj.required' => 'O CNPJ é obrigatório.',
            'cnpj.string' => 'O CNPJ deve ser uma string.',
            'cnpj.size' => 'O CNPJ deve ter exatamente 14 caracteres.',
            'cnpj.unique' => 'Este CNPJ já está cadastrado.',
            'id_usuario.required' => 'O ID do usuário é obrigatório.',
            'id_usuario.exists' => 'O ID do usuário informado não existe.',
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
