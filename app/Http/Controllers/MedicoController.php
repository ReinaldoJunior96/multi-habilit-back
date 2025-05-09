<?php

namespace App\Http\Controllers;

use App\Http\Requests\MedicoRequest;
use App\Models\Medico;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class MedicoController extends Controller
{
    private function getLoggedUserId()
    {
        return auth('api')->check() ? auth('api')->user()->id : 'usuário não autenticado';
    }

    public function index()
    {
        try {
            $medicos = Medico::all();

            Log::info('Médicos listados com sucesso', [
                'usuario_logado' => $this->getLoggedUserId()
            ]);

            return response()->json($medicos, 200);
        } catch (\Exception $e) {
            Log::error('Erro ao listar médicos', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'usuario_logado' => $this->getLoggedUserId()
            ]);

            return response()->json(['message' => 'Erro ao listar médicos.'], 500);
        }
    }

    public function store(MedicoRequest $request)
    {
        try {
            $medico = Medico::create($request->validated());

            Log::info('Médico criado com sucesso', [
                'medico_id' => $medico->id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);

            return response()->json($medico, 201);
        } catch (\Exception $e) {
            Log::error('Erro ao criar médico', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'usuario_logado' => $this->getLoggedUserId()
            ]);

            return response()->json(['message' => 'Erro ao criar médico.'], 500);
        }
    }

    public function show($id)
    {
        try {
            $medico = Medico::findOrFail($id);

            Log::info('Médico recuperado com sucesso', [
                'medico_id' => $id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);

            return response()->json($medico, 200);
        } catch (ModelNotFoundException $e) {
            Log::error('Médico não encontrado', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'medico_id' => $id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);

            return response()->json(['message' => 'Médico não encontrado.'], 404);
        } catch (\Exception $e) {
            Log::error('Erro ao recuperar médico', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'medico_id' => $id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);

            return response()->json(['message' => 'Erro ao recuperar médico.'], 500);
        }
    }

    public function update(MedicoRequest $request, $id)
    {
        try {
            $medico = Medico::findOrFail($id);
            $medico->update($request->validated());

            Log::info('Médico atualizado com sucesso', [
                'medico_id' => $id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);

            return response()->json($medico, 200);
        } catch (ModelNotFoundException $e) {
            Log::error('Médico não encontrado para atualização', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'medico_id' => $id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);

            return response()->json(['message' => 'Médico não encontrado.'], 404);
        } catch (\Exception $e) {
            Log::error('Erro ao atualizar médico', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'medico_id' => $id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);

            return response()->json(['message' => 'Erro ao atualizar médico.'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $medico = Medico::findOrFail($id);
            $medico->delete();

            Log::info('Médico deletado com sucesso', [
                'medico_id' => $id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);

            return response()->json(['message' => 'Médico deletado com sucesso.'], 200);
        } catch (ModelNotFoundException $e) {
            Log::error('Médico não encontrado para exclusão', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'medico_id' => $id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);

            return response()->json(['message' => 'Médico não encontrado.'], 404);
        } catch (\Exception $e) {
            Log::error('Erro ao deletar médico', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'medico_id' => $id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);

            return response()->json(['message' => 'Erro ao deletar médico.'], 500);
        }
    }
}
