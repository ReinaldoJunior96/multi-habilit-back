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
            'id_convenio' => 'required|exists:convenios,id',
            'id_especialidade' => 'nullable|exists:especialidades,id',
            'tabela' => 'nullable|string|max:255',
            'codigo' => 'nullable|string|max:255',
            'procedimento' => 'nullable|string|max:255',
            'procedimento_padrao' => 'nullable|string|max:255',
            'grupo' => 'nullable|string|max:255',
            'vacina' => 'nullable|string|max:255',
            'valor_ch' => 'nullable|numeric',
            'filme' => 'nullable|numeric',
            'porte_anestesia' => 'nullable|integer',
            'ch_anestesista' => 'nullable|numeric',
            'custo_operacional' => 'nullable|numeric',
            'numero_auxiliares' => 'nullable|integer',
            'codigo_tuss' => 'nullable|string|max:255',
            'instrumentador' => 'nullable|string|max:255',
            'porte_honorario' => 'nullable|integer',
            'tempo' => 'nullable|string|max:255',
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
            'id_convenio.required' => 'O campo convênio é obrigatório.',
            'id_convenio.exists' => 'O convênio selecionado não existe.',


            'id_especialidade.exists' => 'A especialidade selecionado não existe.',

            'tabela.string' => 'O campo tabela deve ser um texto.',
            'tabela.max' => 'O campo tabela não pode ter mais que 255 caracteres.',

            'codigo.string' => 'O campo código deve ser um texto.',
            'codigo.max' => 'O campo código não pode ter mais que 255 caracteres.',

            'procedimento.string' => 'O campo procedimento deve ser um texto.',
            'procedimento.max' => 'O campo procedimento não pode ter mais que 255 caracteres.',

            'procedimento_padrao.string' => 'O campo procedimento padrão deve ser um texto.',
            'procedimento_padrao.max' => 'O campo procedimento padrão não pode ter mais que 255 caracteres.',

            'grupo.string' => 'O campo grupo deve ser um texto.',
            'grupo.max' => 'O campo grupo não pode ter mais que 255 caracteres.',

            'vacina.string' => 'O campo vacina deve ser um texto.',
            'vacina.max' => 'O campo vacina não pode ter mais que 255 caracteres.',

            'valor_ch.numeric' => 'O campo valor CH deve ser numérico.',

            'filme.numeric' => 'O campo filme deve ser numérico.',

            'porte_anestesia.integer' => 'O campo porte anestesia deve ser um número inteiro.',

            'ch_anestesista.numeric' => 'O campo CH anestesista deve ser numérico.',

            'custo_operacional.numeric' => 'O campo custo operacional deve ser numérico.',

            'numero_auxiliares.integer' => 'O campo número de auxiliares deve ser um número inteiro.',

            'codigo_tuss.string' => 'O campo código TUSS deve ser um texto.',
            'codigo_tuss.max' => 'O campo código TUSS não pode ter mais que 255 caracteres.',

            'instrumentador.string' => 'O campo instrumentador deve ser um texto.',
            'instrumentador.max' => 'O campo instrumentador não pode ter mais que 255 caracteres.',

            'porte_honorario.integer' => 'O campo porte honorário deve ser um número inteiro.',

            'tempo.string' => 'O campo tempo deve ser um texto.',
            'tempo.max' => 'O campo tempo não pode ter mais que 255 caracteres.',
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
