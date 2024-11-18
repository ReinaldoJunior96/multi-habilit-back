<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ConvenioRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Permite que qualquer usuário autorizado faça a solicitação.
    }

    public function rules()
    {
        return [
            'empresa' => 'required|string|max:255',
            'cnpj' => 'required|string|size:14|unique:convenios,cnpj',
            'valor_convenio' => 'required|numeric|min:0',
        ];
    }

    public function messages()
    {
        return [
            'empresa.required' => 'A empresa é obrigatória.',
            'empresa.string' => 'O nome da empresa deve ser um texto.',
            'empresa.max' => 'O nome da empresa não pode exceder 255 caracteres.',

            'cnpj.required' => 'O CNPJ é obrigatório.',
            'cnpj.string' => 'O CNPJ deve ser um texto.',
            'cnpj.size' => 'O CNPJ deve ter exatamente 14 caracteres.',
            'cnpj.unique' => 'Este CNPJ já está cadastrado.',

            'valor_convenio.required' => 'O valor do convênio é obrigatório.',
            'valor_convenio.numeric' => 'O valor do convênio deve ser um número.',
            'valor_convenio.min' => 'O valor do convênio não pode ser negativo.',
        ];
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        // Personaliza a resposta JSON em caso de erro de validação
        throw new HttpResponseException(response()->json([
            'message' => 'Os dados fornecidos são inválidos.',
            'errors' => $validator->errors()
        ], 422));
    }
}
