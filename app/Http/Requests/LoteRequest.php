<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class LoteRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'lote' => 'nullable|string|max:255',
            'ids_fichas' => 'nullable|array|min:1',
            'ids_fichas.*' => 'integer|exists:fichas_medicas,id',
        ];
    }

    public function messages()
    {
        return [
            'ids_fichas.required' => 'É obrigatório informar ao menos uma ficha.',
            'ids_fichas.*.exists' => 'Uma ou mais fichas não existem.',
        ];
    }

    protected function failedValidation($validator)
    {
        throw new HttpResponseException(response()->json([
            'message' => 'Erro de validação.',
            'errors' => $validator->errors(),
        ], 422));
    }
}
