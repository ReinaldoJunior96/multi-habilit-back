<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrcamentoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nome_paciente' => 'nullable|string|max:255',
            'tipo_servico' => 'nullable|string|max:255',
            'numero_sessoes' => 'nullable|integer|min:1',
            'valor_unitario' => 'nullable|numeric|min:0',
            'desconto' => 'nullable|numeric|min:0|max:100',
            'status' => 'nullable|string',
            'observacoes' => 'nullable|string',
        ];
    }

    /**
     * Get custom error messages for validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'nome_paciente.string' => 'O campo nome do paciente deve ser um texto.',
            'nome_paciente.max' => 'O campo nome do paciente não pode ter mais que 255 caracteres.',

            'tipo_servico.string' => 'O campo tipo de serviço deve ser um texto.',
            'tipo_servico.max' => 'O campo tipo de serviço não pode ter mais que 255 caracteres.',

            'numero_sessoes.integer' => 'O campo número de sessões deve ser um número inteiro.',
            'numero_sessoes.min' => 'O campo número de sessões deve ser no mínimo 1.',

            'valor_unitario.numeric' => 'O campo valor unitário deve ser numérico.',
            'valor_unitario.min' => 'O campo valor unitário deve ser no mínimo 0.',

            'desconto.numeric' => 'O campo desconto deve ser numérico.',
            'desconto.min' => 'O campo desconto deve ser no mínimo 0%.',
            'desconto.max' => 'O campo desconto deve ser no máximo 100%.',

            'observacoes.string' => 'O campo observações deve ser um texto.',
            'status.string' => 'O campo observações deve ser um texto.',
        ];
    }
}
