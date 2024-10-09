<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class PacienteRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'estado_civil' => 'required|string|max:20',
            'nome_mae' => 'required|string|max:200',
            'nome_pai' => 'nullable|string|max:200',
            'prefrencial' => 'required|boolean',
            'cns' => 'nullable|string',
            'nome_conjuge' => 'nullable|string|max:255',
            'cor_raca' => 'nullable|string|max:50',
            'profissao' => 'nullable|string|max:255',
            'instrucao' => 'nullable|string',
            'nacionalidade' => 'nullable|string|max:100',
            'tipo_sanguineo' => 'nullable|string|max:5',
            'id_usuario' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'estado_civil.required' => 'O estado civil é obrigatório.',
            'nome_mae.required' => 'O nome da mãe é obrigatório.',
            'id_usuario.required' => 'O ID do usuário é obrigatório.',
            'id_usuario.exists' => 'O usuário informado não existe.',
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
