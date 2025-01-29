<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ConvenioRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Permite que qualquer usuário autorizado faça a solicitação.
    }

    public function rules()
    {
        $convenioId = $this->route('id'); // Obtém o ID do convênio da rota

        return [
            'codigo' => [
                'nullable',
                'string',
                'max:255',
                'unique:convenios,codigo,' . $convenioId, // Ignora o convênio atual
            ],
            'modo_recebimento' => 'nullable|string|max:255',
            'descricao' => 'nullable|string|max:255',
            'razao_social' => 'nullable|string|max:255',
            'cnpj' => [
                'string',
                'size:14',
                'unique:convenios,cnpj,' . $convenioId,
            ],
            'inscricao_estadual' => 'nullable|string|max:255',
            'inscricao_municipal' => 'nullable|string|max:255',
            'telefone' => 'nullable|string|max:20',
            'contato' => 'nullable|string|max:255',
            'site' => 'nullable|url|max:255',
            'email' => 'nullable|email|max:255',
            'observacao' => 'nullable|string',
            'procedimentos' => 'nullable',
            'medicamentos' => 'nullable',
            'taxas' => 'nullable',
            'materiais' => 'nullable',
            'valor_filme' => 'nullable|min:0',
            'dias_retorno_eletivo' => 'required|integer|min:0',
            'dias_retorno_emergencia' => 'required|integer|min:0',
            'vencimento_contrato' => 'nullable|date',
            'tag_impressao_de_saia' => 'nullable|string|max:255',
            'plano_de_contas' => 'required|string|max:255',
            'alerta_ficha_atendimento' => 'nullable|string|max:255',
            'cep' => 'nullable|string|max:9',
            'cidade' => 'nullable|string|max:255',
            'estado' => 'nullable|string|max:2',
            'endereco' => 'nullable|string|max:255',
            'numero' => 'nullable|string|max:255',
            'complemento' => 'nullable|string|max:255',
            'bairro' => 'nullable|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            'codigo.string' => 'O código deve ser um texto.',
            'codigo.max' => 'O código não pode exceder 255 caracteres.',
            'codigo.unique' => 'Este código já está cadastrado.',

            'modo_recebimento.string' => 'O modo de recebimento deve ser um texto.',
            'modo_recebimento.max' => 'O modo de recebimento não pode exceder 255 caracteres.',

            'descricao.string' => 'A descrição deve ser um texto.',
            'descricao.max' => 'A descrição não pode exceder 255 caracteres.',

            'razao_social.string' => 'A razão social deve ser um texto.',
            'razao_social.max' => 'A razão social não pode exceder 255 caracteres.',

            'cnpj.string' => 'O CNPJ deve ser um texto.',
            'cnpj.size' => 'O CNPJ deve ter exatamente 14 caracteres.',
            'cnpj.unique' => 'Este CNPJ já está cadastrado.',

            'inscricao_estadual.string' => 'A inscrição estadual deve ser um texto.',
            'inscricao_estadual.max' => 'A inscrição estadual não pode exceder 255 caracteres.',

            'inscricao_municipal.string' => 'A inscrição municipal deve ser um texto.',
            'inscricao_municipal.max' => 'A inscrição municipal não pode exceder 255 caracteres.',

            'telefone.string' => 'O telefone deve ser um texto.',
            'telefone.max' => 'O telefone não pode exceder 20 caracteres.',

            'contato.string' => 'O contato deve ser um texto.',
            'contato.max' => 'O contato não pode exceder 255 caracteres.',

            'site.url' => 'O site deve ser uma URL válida.',
            'site.max' => 'O site não pode exceder 255 caracteres.',

            'email.email' => 'O email deve ser um endereço de email válido.',
            'email.max' => 'O email não pode exceder 255 caracteres.',

            'valor_filme.required' => 'O valor do filme é obrigatório.',
            'valor_filme.min' => 'O valor do filme não pode ser negativo.',

            'dias_retorno_eletivo.integer' => 'Os dias de retorno eletivo devem ser um número inteiro.',
            'dias_retorno_eletivo.min' => 'Os dias de retorno eletivo não podem ser negativos.',

            'dias_retorno_emergencia.integer' => 'Os dias de retorno emergência devem ser um número inteiro.',
            'dias_retorno_emergencia.min' => 'Os dias de retorno emergência não podem ser negativos.',

            'vencimento_contrato.date' => 'A data de vencimento deve ser uma data válida.',

            'cep.string' => 'O CEP deve ser um texto.',
            'cep.max' => 'O CEP não pode exceder 9 caracteres.',

            'cidade.string' => 'A cidade deve ser um texto.',
            'cidade.max' => 'A cidade não pode exceder 255 caracteres.',

            'estado.string' => 'O estado deve ser um texto.',
            'estado.max' => 'O estado não pode exceder 2 caracteres.',

            'endereco.string' => 'O endereço deve ser um texto.',
            'endereco.max' => 'O endereço não pode exceder 255 caracteres.',

            'numero.string' => 'O número deve ser um texto.',
            'numero.max' => 'O número não pode exceder 255 caracteres.',

            'complemento.string' => 'O complemento deve ser um texto.',
            'complemento.max' => 'O complemento não pode exceder 255 caracteres.',

            'bairro.string' => 'O bairro deve ser um texto.',
            'bairro.max' => 'O bairro não pode exceder 255 caracteres.',
        ];
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        // Personaliza a resposta JSON em caso de erro de validação
        throw new HttpResponseException(response()->json([
            'message' => 'Os dados fornecidos são inválidos.',
            'errors' => $validator->errors(),
        ], 422));
    }
}
