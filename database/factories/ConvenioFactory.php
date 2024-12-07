<?php

namespace Database\Factories;

use App\Models\Convenio;
use App\Models\Paciente;
use Illuminate\Database\Eloquent\Factories\Factory;

class ConvenioFactory extends Factory
{
    protected $model = Convenio::class;

    public function definition(): array
    {
        return [
            'codigo' => $this->faker->unique()->numerify('CONV-###'), // Código único
            'modo_recebimento' => $this->faker->randomElement(['Manual', 'Automático']), // Exemplo de modo de recebimento
            'descricao' => $this->faker->sentence(3), // Descrição
            'razao_social' => $this->faker->company, // Razão social
            'cnpj' => $this->faker->numerify('##.###.###/####-##'), // CNPJ
            'inscricao_estadual' => $this->faker->numerify('########'), // Inscrição estadual
            'inscricao_municipal' => $this->faker->numerify('########'), // Inscrição municipal
            'telefone' => $this->faker->phoneNumber, // Telefone
            'contato' => $this->faker->name, // Nome do contato
            'site' => $this->faker->url, // URL do site
            'email' => $this->faker->unique()->safeEmail, // Email único
            'observacao' => $this->faker->text(100), // Observação curta
            'procedimentos' => $this->faker->word, // Procedimentos em JSON
            'medicamentos' => $this->faker->word, // Medicamentos em JSON
            'taxas' => $this->faker->word, // Taxas em JSON
            'materiais' => $this->faker->word, // Materiais em JSON
            'valor_filme' => $this->faker->randomFloat(2, 0, 1000), // Valor filme entre 0 e 1000
            'dias_retorno_eletivo' => $this->faker->numberBetween(1, 30), // Dias retorno eletivo
            'dias_retorno_emergencia' => $this->faker->numberBetween(1, 30), // Dias retorno emergência
            'vencimento_contrato' => $this->faker->date, // Data de vencimento do contrato
            'tag_impressao_de_saia' => $this->faker->word, // Tag de impressão
            'plano_de_contas' => $this->faker->word, // Plano de contas
            'alerta_ficha_atendimento' => $this->faker->sentence(3), // Alerta na ficha

            // Endereço
            'cep' => $this->faker->postcode, // CEP
            'cidade' => $this->faker->city, // Cidade
            'estado' => $this->faker->stateAbbr, // Estado
            'endereco' => $this->faker->streetAddress, // Endereço
            'numero' => $this->faker->buildingNumber, // Número
            'complemento' => $this->faker->secondaryAddress, // Complemento
            'bairro' => $this->faker->citySuffix, // Bairro

            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
