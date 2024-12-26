<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class HorarioRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'medico_id' => 'required|exists:medicos,id',
            'data_hora_final' => 'required|date|after:now',
            'data_hora_inicial' => 'required|date|after:now',
        ];
    }

    public function messages()
    {
        return [
            'medico_id.required' => 'O ID do médico é obrigatório.',
            'medico_id.exists' => 'O médico informado não existe.',
            'data_hora_final.required' => 'A data e hora são obrigatórias.',
            'data_hora_final.date' => 'A data e hora devem ser uma data válida.',
            'data_hora_final.after' => 'A data e hora devem ser no futuro.',
            'data_hora_inicial.required' => 'A data e hora são obrigatórias.',
            'data_hora_inicial.date' => 'A data e hora devem ser uma data válida.',
            'data_hora_inicial.after' => 'A data e hora devem ser no futuro.',
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
