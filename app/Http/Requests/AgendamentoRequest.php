<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class AgendamentoRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'atendente' => 'required|exists:atendentes,id',
            'paciente' => 'required|exists:usuarios,id',
            'medico' => 'required|exists:medicos,id',
            'data_agendada' => 'required|date',
            'status' => 'required|integer',
        ];
    }

    public function messages()
    {
        return [
            'atendente.required' => 'O campo atendente é obrigatório.',
            'atendente.exists' => 'O atendente informado não existe.',
            'paciente.required' => 'O campo paciente é obrigatório.',
            'paciente.exists' => 'O paciente informado não existe.',
            'medico.required' => 'O campo médico é obrigatório.',
            'medico.exists' => 'O médico informado não existe.',
            'data_agendada.required' => 'A data agendada é obrigatória.',
            'data_agendada.date' => 'A data agendada deve ser uma data válida.',
            'status.required' => 'O status é obrigatório.',
            'status.integer' => 'O status deve ser um número inteiro.',
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
