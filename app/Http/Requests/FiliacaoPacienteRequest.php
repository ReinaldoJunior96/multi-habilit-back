<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FiliacaoPacienteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id_paciente' => 'required|exists:pacientes,id',

            // Pai
            'cpf_pai' => 'nullable|string|max:14',
            'ocupacao_pai' => 'nullable|string|max:100',
            'email_pai' => 'nullable|email|max:255',
            'telefone_pai' => 'nullable|string|max:20',
            'celular_pai' => 'nullable|string|max:20',

            // Mãe
            'cpf_mae' => 'nullable|string|max:14',
            'ocupacao_mae' => 'nullable|string|max:100',
            'email_mae' => 'nullable|email|max:255',
            'telefone_mae' => 'nullable|string|max:20',
            'celular_mae' => 'nullable|string|max:20',

            // Nota Fiscal
            'nome_nf' => 'nullable|string|max:255',
            'cpf_nf' => 'nullable|string|max:14',
            'ocupacao_nf' => 'nullable|string|max:100',
            'email_nf' => 'nullable|email|max:255',
            'telefone_nf' => 'nullable|string|max:20',
            'celular_nf' => 'nullable|string|max:20',
        ];
    }
}
