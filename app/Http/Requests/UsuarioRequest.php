<?php

namespace App\Http\Requests;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class UsuarioRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $usuarioId = $this->route('id'); // Pega o ID do usuário a ser editado (se houver)

        return [
            'nome_completo' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                // Verifica se o email é único, considerando soft deletes
                Rule::unique('usuarios', 'email')->ignore($usuarioId)->whereNull('deleted_at'),
            ],
            'password' => $usuarioId ? 'nullable|string|min:8' : 'required|string|min:8', // Apenas requer password se for um novo usuário
            'data_nascimento' => 'required|date',
            'sexo' => 'required|string|max:10',
            'rg' => [
                'required',
                'string',
                'max:20',
                // Verifica se o RG é único, considerando soft deletes
                Rule::unique('usuarios', 'rg')->ignore($usuarioId)->whereNull('deleted_at'),
            ],
            'cpf' => [
                'required',
                'string',
                'size:11',
                // Verifica se o CPF é único, considerando soft deletes
                Rule::unique('usuarios', 'cpf')->ignore($usuarioId)->whereNull('deleted_at'),
            ],
            'nome_social' => 'nullable|string|max:255',
            'telefone' => 'nullable|string|max:20',
            'celular' => 'nullable|string|max:20',
        ];
    }

    public function messages()
    {
        return [
            'nome_completo.required' => 'O nome completo é obrigatório.',
            'email.required' => 'O e-mail é obrigatório.',
            'email.email' => 'O e-mail deve ser válido.',
            'email.unique' => 'Este e-mail já está cadastrado.',
            'password.required' => 'A senha é obrigatória.',
            'password.min' => 'A senha deve ter no mínimo 8 caracteres.',
            'data_nascimento.required' => 'A data de nascimento é obrigatória.',
            'data_nascimento.date' => 'A data de nascimento deve ser uma data válida.',
            'sexo.required' => 'O campo sexo é obrigatório.',
            'rg.required' => 'O RG é obrigatório.',
            'rg.unique' => 'Este RG já está cadastrado.',
            'cpf.required' => 'O CPF é obrigatório.',
            'cpf.size' => 'O CPF deve ter exatamente 11 caracteres.',
            'cpf.unique' => 'Este CPF já está cadastrado.',
            'telefone.max' => 'O telefone deve ter no máximo 20 caracteres.',
            'celular.max' => 'O celular deve ter no máximo 20 caracteres.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'message' => 'Os dados fornecidos são inválidos.',
            'errors' => $validator->errors()
        ], 422));
    }
}
