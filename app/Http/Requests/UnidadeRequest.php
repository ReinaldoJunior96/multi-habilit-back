<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Http\Exceptions\HttpResponseException;

class UnidadeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->unidade ?? $this->id ?? null;
        return [
            'nome' => 'required|string|max:255',
            'id_endereco' => 'required|exists:enderecos,id',
            'telefone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'cnpj' => [
                'nullable',
                'string',
                'max:20',
                Rule::unique('unidades', 'cnpj')->ignore($id),
            ],
            'responsavel' => 'nullable|string|max:255',
            'horario_funcionamento' => 'nullable|string|max:255',
            'status' => 'nullable|string|max:20',
            'tipo' => 'nullable|string|max:20',
        ];
    }

    public function messages(): array
    {
        return [
            'nome.required' => 'O nome é obrigatório.',
            'nome.string' => 'O nome deve ser um texto.',
            'id_endereco.required' => 'O endereço é obrigatório.',
            'id_endereco.exists' => 'O endereço informado não existe.',
            'email.email' => 'O e-mail deve ser válido.',
            'cnpj.unique' => 'O CNPJ já está cadastrado.',
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
