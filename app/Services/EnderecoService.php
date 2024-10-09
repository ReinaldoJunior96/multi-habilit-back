<?php

namespace App\Services;

use App\Models\Endereco;

class EnderecoService
{
    /**
     * Cria um novo endereço.
     *
     * @param array $data
     * @return Endereco
     */
    public function createEndereco(array $data)
    {


        // Cria o novo endereço
        $endereco = new Endereco();
        $endereco->cep = $data['cep'];
        $endereco->logradouro = $data['logradouro'];
        $endereco->complemento = $data['complemento'] ?? null;
        $endereco->bairro = $data['bairro'];
        $endereco->uf = $data['uf'];
        $endereco->id_usuario = $data['id_usuario'];
        $endereco->save();

        // Retorna o endereço criado
        return response()->json($endereco, 201);
    }

    /**
     * Atualiza um endereço.
     *
     * @param array $data
     * @param int $id
     * @return Endereco
     */
    public function updateEndereco(array $data, int $id)
    {
        $endereco = Endereco::findOrFail($id);

        $endereco->update($data);

        return $endereco;
    }

    /**
     * Deleta um endereço.
     *
     * @param int $id
     * @return void
     */
    public function deleteEndereco(int $id)
    {

        Endereco::findOrFail($id)->delete();
        return response()->json(['message' => 'Endereço deletado com sucesso.'], 200);
    }

    /**
     * Retorna todos os endereços.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllEnderecos()
    {
        return Endereco::all();
    }

    /**
     * Retorna um endereço específico.
     *
     * @param int $id
     * @return Endereco
     */
    public function getEnderecoById(int $id)
    {

        return Endereco::findOrFail($id);
    }
}
