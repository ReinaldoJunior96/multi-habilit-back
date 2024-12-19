<?php

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ProcedimentoRequest extends FormRequest
{
    /**
     * Determina se o usuário está autorizado a fazer essa solicitação.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Define as regras de validação.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'codigo' => 'required|string|max:50|unique:procedimentos,codigo,' . $this->route('procedimento'),
            'nome' => 'required|string|max:255',
            'valor_ch' => 'required|numeric|min:0',
            'porte_anestesia' => 'nullable|integer|min:0',
            'ch_anestesista' => 'nullable|integer|min:0',
            'custo_operacional' => 'nullable|numeric|min:0',
            'num_auxiliares' => 'nullable|integer|min:0',
            'tempo' => 'nullable|integer|min:0',
            'valor_filme' => 'nullable|numeric|min:0',
            'codigo_tuss' => 'string|nullable',
            'convenio_id' => 'required',
        ];
    }

    /**
     * Define mensagens personalizadas para erros de validação.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'codigo.required' => 'O campo código é obrigatório.',
            'codigo.string' => 'O campo código deve ser uma string.',
            'codigo.max' => 'O campo código não pode ter mais que 50 caracteres.',
            'codigo.unique' => 'O código informado já está em uso.',
            'nome.required' => 'O nome do procedimento é obrigatório.',
            'nome.string' => 'O campo nome deve ser uma string.',
            'nome.max' => 'O nome do procedimento não pode ter mais que 255 caracteres.',
            'valor_ch.required' => 'O campo valor/CH é obrigatório.',
            'valor_ch.numeric' => 'O campo valor/CH deve ser numérico.',
            'valor_ch.min' => 'O campo valor/CH deve ser maior ou igual a 0.',
            'porte_anestesia.integer' => 'O campo porte anestésico deve ser um número inteiro.',
            'porte_anestesia.min' => 'O campo porte anestésico deve ser maior ou igual a 0.',
            'ch_anestesista.integer' => 'O campo CH do anestesista deve ser um número inteiro.',
            'ch_anestesista.min' => 'O campo CH do anestesista deve ser maior ou igual a 0.',
            'custo_operacional.numeric' => 'O campo custo operacional deve ser numérico.',
            'custo_operacional.min' => 'O campo custo operacional deve ser maior ou igual a 0.',
            'num_auxiliares.integer' => 'O campo número de auxiliares deve ser um número inteiro.',
            'num_auxiliares.min' => 'O campo número de auxiliares deve ser maior ou igual a 0.',
            'tempo.integer' => 'O campo tempo deve ser um número inteiro.',
            'tempo.min' => 'O campo tempo deve ser maior ou igual a 0.',
            'valor_filme.numeric' => 'O campo valor do filme deve ser numérico.',
            'valor_filme.min' => 'O campo valor do filme deve ser maior ou igual a 0.',
            'codigo_tuss.string' => 'O campo código deve ser uma string.',
            'convenio_id.required' => 'Convenio é obrigatório',
        ];
    }

    /**
     * Customiza a resposta em caso de falha na validação.
     *
     * @param Validator $validator
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'message' => 'Os dados fornecidos são inválidos.',
            'errors' => $validator->errors()
        ], 422));
    }
}
