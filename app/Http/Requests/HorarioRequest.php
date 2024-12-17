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
            'data_hora' => 'required|date|after:now',
        ];
    }

    public function messages()
    {
        return [
            'medico_id.required' => 'O ID do médico é obrigatório.',
            'medico_id.exists' => 'O médico informado não existe.',
            'data_hora.required' => 'A data e hora são obrigatórias.',
            'data_hora.date' => 'A data e hora devem ser uma data válida.',
            'data_hora.after' => 'A data e hora devem ser no futuro.',
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
