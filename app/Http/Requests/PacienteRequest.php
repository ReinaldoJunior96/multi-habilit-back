<?php


namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class PacienteRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'nome' => 'required|string|max:255',
            'nome_social' => 'nullable|string|max:255',
            'nascimento' => 'nullable|date',
            'sexo' => 'nullable|string|in:Masculino,Feminino,Outro',
            'estado_civil' => 'nullable|string',
            'preferencial' => 'nullable|string',
            'inscricao_municipal' => 'nullable|string',
            'telefone' => 'nullable|string',
            'identidade_rg' => 'nullable|string',
            'cns' => 'nullable|string',
            'cpf' => 'nullable|string',
            'mae' => 'nullable|string',
            'pai' => 'nullable|string',
            'rn' => 'nullable|boolean',
            'oncologico' => 'nullable|boolean',
            'conjuge' => 'nullable|string',
            'cor_raca' => 'nullable|string',
            'nacionalidade' => 'nullable|string',
            'profissao' => 'nullable|string',
            'instrucao' => 'nullable|string',

            // Responsável
            'responsavel_nome' => 'nullable|string',
            'responsavel_rg' => 'nullable|string',
            'responsavel_telefone' => 'nullable|string',
            'responsavel_parentesco' => 'nullable|string',
            'responsavel_ocupacao' => 'nullable|string',
            'responsavel_email' => 'nullable|email',

            // Contato
            'contato_celular' => 'nullable|string',
            'contato_email' => 'nullable|email',

            'filiacao' => 'nullable|array',
        ];
    }

    public function messages()
    {
        return [
            'nome.required' => 'O campo nome é obrigatório.',
            '*.string' => 'O campo :attribute deve ser um texto.',
            '*.date' => 'O campo :attribute deve ser uma data válida.',
            '*.email' => 'O campo :attribute deve ser um e-mail válido.',
            '*.boolean' => 'O campo :attribute deve ser verdadeiro ou falso.',
        ];
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'message' => 'Os dados fornecidos são inválidos.',
            'errors' => $validator->errors(),
        ], 422));
    }
}
