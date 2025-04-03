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
            'atendente' => 'required|exists:usuarios,id',
            'paciente' => 'required|exists:pacientes,id',
            'medico_id' => 'required|exists:medicos,id',
            'medico_substituto' => 'nullable|exists:medicos,id',
            'convenio' => 'required|exists:convenios,id',
            'procedimento' => 'nullable|exists:procedimentos,id',
            'data_agendada' => 'required|date',
            'unidade' => 'nullable|string',
            'status' => 'required|integer|in:0,1,2,3,4,5',
        ];
    }

    public function messages()
    {
        return [
            'atendente.required' => 'O campo atendente é obrigatório.',
            'atendente.exists' => 'O atendente informado não existe.',
            'paciente.required' => 'O campo paciente é obrigatório.',
            'paciente.exists' => 'O paciente informado não existe.',
            'medico_id.required' => 'O campo médico é obrigatório.',
            'medico_id.exists' => 'O médico informado não existe.',
            'medico_substituto.exists' => 'O médico substituto informado não existe.',
            'data_agendada.required' => 'A data agendada é obrigatória.',
            'data_agendada.date' => 'A data agendada deve ser uma data válida.',
            'status.required' => 'O status é obrigatório.',
            'status.integer' => 'O status deve ser um número inteiro.',
            'status.in' => 'O status deve ser entre 0 e 5.',
            'convenio.required' => 'O convênio é obrigatório.',
            'convenio.exists' => 'O convênio informado não existe.',
            'procedimento.exists' => 'O procedimento informado não existe.',
            'unidade.string' => 'A unidade deve ser uma string válida.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'message' => 'Os dados fornecidos são inválidos.',
            'errors' => $validator->errors(),
        ], 422));
    }
}
