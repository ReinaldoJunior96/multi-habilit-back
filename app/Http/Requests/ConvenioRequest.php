<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ConvenioRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'empresa' => 'required|string|max:255',
            'tipo' => 'required|string|max:50',
            'vencimento' => 'nullable|date',
            'percentual_coparticipacao' => 'integer|min:0|max:100',
            'particular' => 'boolean',
            'id_paciente' => 'required|exists:pacientes,id',
        ];
    }

    public function messages()
    {
        return [
            'empresa.required' => 'A empresa é obrigatória.',
            'tipo.required' => 'O tipo de convênio é obrigatório.',
            'vencimento.date' => 'A data de vencimento deve ser uma data válida.',
            'percentual_coparticipacao.integer' => 'O percentual de coparticipação deve ser um número inteiro.',
            'particular.boolean' => 'O campo particular deve ser verdadeiro ou falso.',
            'id_paciente.required' => 'O ID do paciente é obrigatório.',
            'id_paciente.exists' => 'O paciente selecionado não existe.',
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
