<?php

namespace App\Services;

use App\Models\Atendente;

class AtendenteService
{
    /**
     * Cria um novo atendente.
     *
     * @param array $data
     * @return Atendente
     */
    public function createAtendente(array $data)
    {
        // Criação manual dos dados
        $atendente = new Atendente();
        $atendente->id_usuario = $data['id_usuario'];

        $atendente->save();

        return $atendente;
    }

    /**
     * Atualiza um atendente.
     *
     * @param array $data
     * @param int $id
     * @return Atendente
     */
    public function updateAtendente(array $data, int $id)
    {
        $atendente = Atendente::findOrFail($id);

        $atendente->update($data);

        return $atendente;
    }

    /**
     * Deleta um atendente.
     *
     * @param int $id
     * @return void
     */
    public function deleteAtendente(int $id)
    {
        $exist = Atendente::where('id', $id)->exists();

        if ($exist) {
            Atendente::findOrFail($id)->delete();
            return response()->json(['message' => 'Atendente deletado com sucesso.'], 200);
        }

        return response()->json(['message' => 'Atendente não existe.'], 400);
    }

    /**
     * Retorna todos os atendentes.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllAtendentes()
    {
        return Atendente::with('usuario')->get();
    }

    /**
     * Retorna um atendente específico.
     *
     * @param int $id
     * @return Atendente
     */
    public function getAtendenteById(int $id)
    {
        return Atendente::findOrFail($id);
    }
}
