<?php


namespace App\Services;

use App\Models\Medico;
use Illuminate\Http\Request;

class MedicoService
{
    public function createMedico(array $data)
    {
        // Instancia um novo modelo de Medico
        $medico = new Medico();

        // Define cada campo manualmente
        $medico->regime_trabalhista = $data['regime_trabalhista'];
        $medico->carga_horaria = $data['carga_horaria'];
        $medico->cnpj = $data['cnpj'];
        $medico->id_usuario = $data['id_usuario'];

        // Qualquer lógica adicional antes de salvar, como manipulações ou validações personalizadas

        // Salva o modelo no banco de dados
        $medico->save();
        // Retorna o médico criado
        return $medico;
    }

    public function updateMedico(Medico $medico, array $data)
    {
        return $medico->update($data);
    }

    public function deleteMedico(Medico $medico)
    {
        return $medico->delete();
    }

    public function findMedicoById($id)
    {
        return Medico::with('usuario')->find($id);
    }

    public function listMedicos()
    {
        return Medico::with('usuario')->get();
    }
}
