<?php

namespace App\Services;

use App\Models\Procedimento;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProcedimentoService
{
    protected $procedimento;

    public function __construct(Procedimento $procedimento)
    {
        $this->procedimento = $procedimento;
    }

    public function getAllProcedimentos()
    {
        return $this->procedimento->all();
    }

    public function getProcedimentoById($id)
    {
        return $this->procedimento->findOrFail($id);
    }

    public function createProcedimento(array $data)
    {

        return $this->procedimento->create($data);
    }

    public function updateProcedimento($id, array $data)
    {
        $procedimento = $this->getProcedimentoById($id);
        $procedimento->update($data);
        return $procedimento;
    }

    public function deleteProcedimento($id)
    {
        $procedimento = $this->getProcedimentoById($id);
        $procedimento->delete();
    }
}
