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
        $id = request()->route('medico') ?? request()->route('id');
        return [
            'nome_completo' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:medicos,email' . ($id ? ",{$id}" : ''),
            'data_nascimento' => 'nullable|date',
            'sexo' => 'nullable',
            'cpf' => 'nullable|unique:medicos,cpf' . ($id ? ",{$id}" : ''),
            'telefone' => 'nullable|string|max:20',
            'tipo' => 'required|string',
            'regime_trabalhista' => 'nullable',
            'carga_horaria' => 'nullable|integer|min:1|max:60',
            'cnpj' => 'nullable|unique:medicos,cnpj' . ($id ? ",{$id}" : ''),
            'especialidade' => 'nullable|string',
            'regime_profissional' => 'nullable|string',
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
            'nome_completo.required' => 'O nome completo é obrigatório.',
            'nome_completo.string' => 'O nome completo deve ser uma string.',
            'nome_completo.max' => 'O nome completo não pode exceder 255 caracteres.',
            'email.required' => 'O e-mail é obrigatório.',
            'email.email' => 'O e-mail deve ser válido.',
            'email.max' => 'O e-mail não pode exceder 255 caracteres.',
            'email.unique' => 'O e-mail já está em uso.',
            'data_nascimento.date' => 'A data de nascimento deve ser uma data válida.',
            'cpf.unique' => 'O CPF já está em uso.',
            'cnpj.unique' => 'O CNPJ já está em uso.',
            'telefone.string' => 'O telefone deve ser uma string.',
            'telefone.max' => 'O telefone não pode exceder 20 caracteres.',
            'tipo.required' => 'O tipo é obrigatório.',
            'tipo.string' => 'O tipo deve ser uma string.',
            'regime_trabalhista.required' => 'O regime trabalhista é obrigatório.',
            'carga_horaria.integer' => 'A carga horária deve ser um número inteiro.',
            'especialidade.string' => 'O telefone deve ser uma string.',
            'regime_profissional.string' => 'O telefone deve ser uma string.',
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
