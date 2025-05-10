<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class EspecialidadeRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'cor' => 'nullable|string|size:7|regex:/^#[0-9A-Fa-f]{6}$/',
            'id_procedimento' => 'nullable|exists:procedimentos,id',
            'ativa' => 'required|boolean',
        ];
    }

    /**
     * Get the custom messages for validation errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'nome.required' => 'O campo nome é obrigatório.',
            'nome.string' => 'O campo nome deve ser um texto.',
            'nome.max' => 'O campo nome não pode ter mais que 255 caracteres.',

            'descricao.string' => 'O campo descrição deve ser um texto.',

            'cor.required' => 'O campo cor é obrigatório.',
            'cor.string' => 'O campo cor deve ser um texto.',
            'cor.size' => 'O campo cor deve ter exatamente 7 caracteres.',
            'cor.regex' => 'O campo cor deve estar no formato hexadecimal (#RRGGBB).',

            'id_procedimento.required' => 'O campo id_procedimento é obrigatório.',
            'id_procedimento.exists' => 'O procedimento informado não foi encontrado.',

            'ativa.required' => 'O campo ativa é obrigatório.',
            'ativa.boolean' => 'O campo ativa deve ser verdadeiro ou falso.',
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
