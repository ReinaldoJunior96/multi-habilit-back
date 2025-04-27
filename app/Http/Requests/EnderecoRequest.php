<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class EnderecoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('id'); // pega o id do endereço na URL, se existir

        return [
            'cep' => 'nullable|string',
            'logradouro' => 'nullable|string',
            'complemento' => 'nullable|string',
            'bairro' => 'nullable|string',
            'municipio' => 'nullable|string',
            'numero' => 'nullable|string',
            'estado' => 'nullable|string',
            'uf' => 'nullable|string|size:2',
            'id_paciente' => [
                'nullable',
                'exists:pacientes,id',
                Rule::unique('enderecos', 'id_paciente')->ignore($id),
            ],
            'id_convenio' => [
                'nullable',
                'exists:convenios,id',
                Rule::unique('enderecos', 'id_convenio')->ignore($id),
            ],
        ];
    }


    public function messages(): array
    {
        return [
            'id_paciente.exists' => 'O paciente informado não foi encontrado.',
            'id_paciente.unique' => 'Este paciente já possui um endereço cadastrado.',
            'id_convenio.exists' => 'O convênio informado não foi encontrado.',
            'id_convenio.unique' => 'Este convênio já possui um endereço cadastrado.',
            '*.string' => 'O campo :attribute deve ser um texto.',
            'uf.size' => 'O campo UF deve conter exatamente 2 caracteres.',
        ];
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'message' => 'Erro de validação.',
            'errors' => $validator->errors(),
        ], 422));
    }
}
