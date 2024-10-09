<?php

namespace App\Services;

use App\Models\Convenio;

class ConvenioService
{
    // Obter todos os convênios
    public function getAllConvenios()
    {
        return Convenio::with('paciente')->get();
    }

    // Obter um convênio por ID
    public function getConvenioById($id)
    {
        return Convenio::with('paciente')->find($id);
    }

    // Criar um novo convênio
    public function createConvenio(array $data)
    {
        return Convenio::create($data);
    }

    // Atualizar um convênio existente
    public function updateConvenio($id, array $data)
    {
        $convenio = Convenio::find($id);

        if (!$convenio) {
            return response()->json(['message' => 'Convenio não existe.'], 200);
        }

        $convenio->update($data);
        return $convenio;
    }

    // Deletar um convênio
    public function deleteConvenio($id)
    {
        $convenio = Convenio::where('id', $id)->exists();

        if ($convenio) {
            Convenio::where('id',  $id)->delete();
            return response()->json(['message' => 'Convenio deletado com sucesso'], 200);
        }

        return response()->json(['message' => 'Convenio não existe.'], 200);
    }
}
