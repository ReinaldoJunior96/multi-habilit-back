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
            'id_atendente' => 'nullable|exists:usuarios,id',
            'id_paciente' => 'required|exists:pacientes,id',
            'id_medico' => 'required|exists:medicos,id',
            'id_medico_substituto' => 'nullable|exists:medicos,id',
            'id_convenio' => 'required|exists:convenios,id',
            'id_procedimento' => 'nullable|exists:procedimentos,id',
            'data_agendada' => 'required|date',
            'unidade' => 'nullable|string',
            'status' => 'required|integer|in:0,1,2,3,4,5',
        ];
    }

    public function messages()
    {
        return [
            'id_atendente.exists' => 'O atendente informado não existe.',
            'id_paciente.required' => 'O campo paciente é obrigatório.',
            'id_paciente.exists' => 'O paciente informado não existe.',
            'id_medico.required' => 'O campo médico é obrigatório.',
            'id_medico.exists' => 'O médico informado não existe.',
            'id_medico_substituto.exists' => 'O médico substituto informado não existe.',
            'data_agendada.required' => 'A data agendada é obrigatória.',
            'data_agendada.date' => 'A data agendada deve ser uma data válida.',
            'status.required' => 'O status é obrigatório.',
            'status.integer' => 'O status deve ser um número inteiro.',
            'status.in' => 'O status deve ser entre 0 e 5.',
            'id_convenio.required' => 'O convênio é obrigatório.',
            'id_convenio.exists' => 'O convênio informado não existe.',
            'id_procedimento.exists' => 'O procedimento informado não existe.',
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
