<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;

class UsuarioRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $usuarioId = $this->route('id'); // Obtém o ID da rota
        Log::info('Validando com ID do usuário:', ['id' => $usuarioId]);

        $rules = [
            'nome_completo' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('usuarios', 'email')->ignore($usuarioId),
            ],
            'password' => $usuarioId ? 'nullable|string|min:8' : 'required|string|min:8',
            'data_nascimento' => 'required|date',
            'sexo' => 'required|string|max:10',
            'rg' => [
                'required',
                'string',
                'max:20',
                Rule::unique('usuarios', 'rg')->ignore($usuarioId),
            ],
            'cpf' => [
                'required',
                'string',
                'size:11',
                Rule::unique('usuarios', 'cpf')->ignore($usuarioId),
            ],
            'nome_social' => 'nullable|string|max:255',
            'telefone' => 'nullable|string|max:20',
            'celular' => 'nullable|string|max:20',
            'role' => 'nullable|in:admin-master,admin,atendente,medico,paciente,colaborador',
        ];


        return $rules;
    }

    public function messages()
    {
        return [
            // Mensagens gerais do usuário
            'nome_completo.required' => 'O nome completo é obrigatório.',
            'email.required' => 'O e-mail é obrigatório.',
            'email.email' => 'O e-mail deve ser válido.',
            'email.unique' => 'Este e-mail já está cadastrado.',
            'password.required' => 'A senha é obrigatória.',
            'password.min' => 'A senha deve ter no mínimo 8 caracteres.',
            'data_nascimento.required' => 'A data de nascimento é obrigatória.',
            'data_nascimento.date' => 'A data de nascimento deve ser uma data válida.',
            'sexo.required' => 'O campo sexo é obrigatório.',
            'rg.required' => 'O RG é obrigatório.',
            'rg.unique' => 'Este RG já está cadastrado.',
            'cpf.required' => 'O CPF é obrigatório.',
            'cpf.size' => 'O CPF deve ter exatamente 11 caracteres.',
            'cpf.unique' => 'Este CPF já está cadastrado.',
            'telefone.max' => 'O telefone deve ter no máximo 20 caracteres.',
            'celular.max' => 'O celular deve ter no máximo 20 caracteres.',
            'role.in' => 'A role do usuário deve ser uma das seguintes: admin-master, admin, atendente, médico, paciente.',

            // Mensagens para médico
            'medico.required' => 'Os dados do médico são obrigatórios para o cadastro.',
            'medico.regime_trabalhista.required' => 'O regime trabalhista do médico é obrigatório.',
            'medico.regime_trabalhista.max' => 'O regime trabalhista do médico deve ter no máximo 50 caracteres.',
            'medico.carga_horaria.required' => 'A carga horária do médico é obrigatória.',
            'medico.carga_horaria.integer' => 'A carga horária do médico deve ser um número inteiro.',
            'medico.carga_horaria.min' => 'A carga horária do médico deve ser no mínimo 1.',
            'medico.carga_horaria.max' => 'A carga horária do médico deve ser no máximo 168 horas por semana.',
            'medico.cnpj.required' => 'O CNPJ do médico é obrigatório.',
            'medico.cnpj.size' => 'O CNPJ deve ter exatamente 14 caracteres.',

            // Mensagens para paciente
            'paciente.estado_civil.required' => 'O estado civil do paciente é obrigatório.',
            'paciente.estado_civil.max' => 'O estado civil do paciente deve ter no máximo 20 caracteres.',
            'paciente.nome_mae.required' => 'O nome da mãe do paciente é obrigatório.',
            'paciente.nome_mae.max' => 'O nome da mãe do paciente deve ter no máximo 200 caracteres.',
            'paciente.nome_pai.max' => 'O nome do pai do paciente deve ter no máximo 200 caracteres.',
            'paciente.preferencial.required' => 'É necessário indicar se o paciente é preferencial.',
            'paciente.preferencial.boolean' => 'O campo preferencial deve ser verdadeiro ou falso.',
            'paciente.cns.max' => 'O CNS do paciente deve ter no máximo 15 caracteres.',
            'paciente.nome_conjuge.max' => 'O nome do cônjuge do paciente deve ter no máximo 255 caracteres.',
            'paciente.cor_raca.max' => 'A cor ou raça do paciente deve ter no máximo 50 caracteres.',
            'paciente.profissao.max' => 'A profissão do paciente deve ter no máximo 255 caracteres.',
            'paciente.instrucao.max' => 'O nível de instrução do paciente deve ter no máximo 255 caracteres.',
            'paciente.nacionalidade.max' => 'A nacionalidade do paciente deve ter no máximo 100 caracteres.',
            'paciente.tipo_sanguineo.max' => 'O tipo sanguíneo do paciente deve ter no máximo 5 caracteres.',

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
