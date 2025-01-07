<?php

namespace App\Services;

use App\Models\Procedimento;

class ProcedimentoService
{
    protected $procedimento;

    public function __construct(Procedimento $procedimento)
    {
        $this->procedimento = $procedimento;
    }

    // Retorna todos os procedimentos
    public function getAllProcedimentos($withTrashed = false)
    {
        $query = $this->procedimento->with('convenio');
        if ($withTrashed) {
            $query = $query->withTrashed();
        }
        return $query->get();
    }

    // Busca um procedimento por ID, com ou sem registros excluídos logicamente
    public function getProcedimentoById($id, $withTrashed = false)
    {
        $query = $withTrashed ? $this->procedimento->withTrashed() : $this->procedimento;
        return $query->findOrFail($id);
    }

    // Cria um novo procedimento
    public function createProcedimento(array $data)
    {
        return $this->procedimento->create($data);
    }

    // Atualiza um procedimento existente
    public function updateProcedimento($id, array $data)
    {
        $procedimento = $this->getProcedimentoById($id);
        $procedimento->fill($data);
        $procedimento->save();

        return $procedimento;
    }

    // Exclui logicamente um procedimento
    public function deleteProcedimento($id)
    {
        $procedimento = $this->getProcedimentoById($id);
        $procedimento->delete();
    }

    // Restaura um procedimento excluído logicamente
    public function restoreProcedimento($id)
    {
        $procedimento = $this->getProcedimentoById($id, true);
        $procedimento->restore();

        return $procedimento;
    }

    // Exclui permanentemente um procedimento
    public function forceDeleteProcedimento($id)
    {
        $procedimento = $this->getProcedimentoById($id, true);
        $procedimento->forceDelete();
    }
}
