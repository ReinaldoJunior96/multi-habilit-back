<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class AtendimentoRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'id_paciente' => 'required|integer|exists:pacientes,id',

            'encaminhador' => 'nullable|string',
            'convenio' => 'nullable|string',
            'plano' => 'nullable|string',
            'carteira' => 'nullable|string',
            'cadastro_antecipado' => 'nullable|boolean',
            'aguardando_autorizacao' => 'nullable|boolean',
            'titular' => 'nullable|string',
            'tipo_consulta' => 'nullable|string',
            'dias_coparticipacao' => 'nullable|string',
            'tipo_atendimento' => 'nullable|string',
            'local_externo' => 'nullable|string',
            'clinica_indicacao' => 'nullable|string',
            'cid' => 'nullable|string',
            'local_atendimento' => 'nullable|string',
            'tipo_atendimento_eletiva_emergencia' => 'nullable|string',
            'setor_emergencia' => 'nullable|string',
            'tipo_acomodacao' => 'nullable|string',
            'leito' => 'nullable|string',
            'diarias_aut' => 'nullable|string',
            'solicitante' => 'nullable|string',
            'realizante' => 'nullable|string',
            'especialidade' => 'nullable|string',
            'numero_guia' => 'nullable|string',
            'autorizacao_data' => 'nullable|date',
            'senha' => 'nullable|string',
            'senha_validade' => 'nullable|date',
            'guia_principal' => 'nullable|string',
            'guia_operadora' => 'nullable|string',
            'observacao_cliente' => 'nullable|string',
            'indicador_acidente' => 'nullable|string',
            'tipo_saida' => 'nullable|string',
            'tipo_doenca' => 'nullable|string',
            'tempo_doenca' => 'nullable|string',
        ];
    }

    public function messages()
    {
        return [
            'id_paciente.required' => 'O campo id_paciente é obrigatório.',
            'id_paciente.integer' => 'O campo id_paciente deve ser um número inteiro.',
            'id_paciente.exists' => 'O paciente informado não foi encontrado.',

            '*.string' => 'O campo :attribute deve ser uma string.',
            '*.boolean' => 'O campo :attribute deve ser verdadeiro ou falso.',
            '*.date' => 'O campo :attribute deve ser uma data válida.',
        ];
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'message' => 'Os dados fornecidos são inválidos.',
            'errors' => $validator->errors(),
        ], 422));
    }
}
