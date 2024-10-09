<?php

namespace App\Services;

use App\Models\Paciente;
use Illuminate\Support\Facades\DB;

class PacienteService
{
    public function getAllPacientes()
    {
        return Paciente::with('usuario')->get();
    }

    public function getPacienteById($id)
    {
        return Paciente::findOrFail($id);
    }

    public function createPaciente($data)
    {
        $exist = Paciente::where('id_usuario', $data['id_usuario'])->exists();

        if ($exist) {
            return response()->json(['message' => 'Paciente já atrelado a um usuário.'], 200);
        }

        return Paciente::create($data);
    }

    public function updatePaciente($data, $id)
    {
        $paciente = Paciente::findOrFail($id);
        $paciente->update($data);
        return $paciente;
    }

    public function deletePaciente($id)
    {
        $paciente = Paciente::findOrFail($id);
        $paciente->delete();
        return response()->json(['message' => 'Paciente removido com sucesso.'], 200);
    }
}
