<?php

namespace App\Services;

use App\Models\Agendamento;

class AgendamentoService
{

    public function __construct()
    {
    }

    public function createAgendamento(array $data)
    {
        return Agendamento::create($data);
    }

    public function updateAgendamento(array $data, int $id)
    {
        $agendamento = Agendamento::findOrFail($id);
        $agendamento->update($data);
        return $agendamento;
    }

    public function deleteAgendamento(int $id)
    {
        Agendamento::findOrFail($id)->delete();
    }

    public function getAllAgendamentos()
    {
        return Agendamento::with('medico.usuario','paciente','atendente.usuario')->get();
    }

    public function getAgendamentoById(int $id)
    {
        return Agendamento::findOrFail($id);
    }
}
