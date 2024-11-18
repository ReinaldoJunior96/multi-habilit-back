<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Convenio;

class ConvenioPacienteController extends Controller
{
    /**
     * Relacionar um paciente a um convênio (store).
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'paciente_id' => 'required|exists:pacientes,id',
            'convenio_id' => 'required|exists:convenios,id',
        ]);

        $convenio = Convenio::findOrFail($validated['convenio_id']);

        // Verifica se o paciente já está associado ao convênio
        if ($convenio->pacientes()->where('paciente_id', $validated['paciente_id'])->exists()) {
            return response()->json([
                'message' => 'O paciente já está associado a este convênio.',
            ], 422);
        }

        // Associa o paciente ao convênio
        $convenio->pacientes()->attach($validated['paciente_id']);

        return response()->json([
            'message' => 'Paciente associado ao convênio com sucesso.',
        ], 201);
    }

    /**
     * Remover um paciente de um convênio.
     */
    public function remover(Request $request)
    {
        $validated = $request->validate([
            'paciente_id' => 'required|exists:pacientes,id',
            'convenio_id' => 'required|exists:convenios,id',
        ]);

        $convenio = Convenio::findOrFail($validated['convenio_id']);

        // Verifica se o paciente está associado ao convênio
        if (!$convenio->pacientes()->where('paciente_id', $validated['paciente_id'])->exists()) {
            return response()->json([
                'message' => 'O paciente não está associado a este convênio.',
            ], 404);
        }

        // Remove o paciente do convênio
        $convenio->pacientes()->detach($validated['paciente_id']);

       
