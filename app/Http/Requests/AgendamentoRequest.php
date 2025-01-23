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
            'atendente' => 'required',
            'paciente' => 'required|exists:usuarios,id',
            'medico_id' => 'required|exists:medicos,id',
            'data_agendada' => ['required', 'date', function ($attribute, $value, $fail) {
                $agora = now();

                $dataHoraAgendada = \Carbon\Carbon::parse($value);

                if ($dataHoraAgendada->isToday() && $dataHoraAgendada->lt($agora)) {
                    // Caso a data seja hoje e a hora seja anterior ao horário atual
                    $fail('A hora da data agendada deve ser posterior à hora atual.');
                } elseif ($dataHoraAgendada->lt($agora->startOfDay())) {
                    // Caso a data seja no passado
                    $fail('A data agendada deve ser no futuro ou hoje com hora válida.');
                }
            }],
            'status' => 'required|integer|in:0,1,2,3,4,5',
            'convenio' => 'nullable|exists:convenios,id',
            'numero_guia' => 'required|string',
            'recorrencia' => 'nullable|in:semanal,mensal',
        ];
    }







    public function messages()
    {
        return [
            'recorrencia.in' => 'O campo recorrência deve ser "semanal" ou "mensal".',
            'atendente.required' => 'O campo atendente é obrigatório.',
            'paciente.required' => 'O campo paciente é obrigatório.',
            'paciente.exists' => 'O paciente informado não existe.',
            'medico_id.required' => 'O campo médico é obrigatório.',
            'medico.exists' => 'O médico informado não existe.',
            'data_agendada.required' => 'A data agendada é obrigatória.',
            'data_agendada.date' => 'A data agendada deve ser uma data válida.',
            'status.required' => 'O status é obrigatório.',
            'status.integer' => 'O status deve ser um número inteiro.',
            'status.in' => 'O status deve ser 0 (pendente), 1 (confirmado) ou 2 (cancelado).',
            'convenio.exists' => 'O convênio informado não existe.',
            'numero_guia.string' => 'O número da guia deve ser um numero válido.',
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
