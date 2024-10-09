<?php

namespace App\Services;

use App\Models\Agendamento;

class AgendamentoService
{

    public function __construct() {}

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

        $exist = Agendamento::where('id', $id)->exists();
        //dd($exist);
        if ($exist) {
            Agendamento::where('id', $id)->delete();
            return response()->json(['message' => 'Agendamento deletado com sucesso.'], 200);
        }

        return response()->json(['message' => 'Agendamento não existe.'], 400);
    }

    public function getAllAgendamentos()
    {
        return Agendamento::with('medico.usuario', 'paciente.usuario', 'atendente.usuario')->get();
    }

    public function getAgendamentoById(int $id)
    {
        return Agendamento::findOrFail($id);
    }
}
