<?php


namespace App\Services;

use App\Models\Medico;
use Illuminate\Http\Request;

class MedicoService
{
    public function createMedico(array $data)
    {
        return Medico::create($data);
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
