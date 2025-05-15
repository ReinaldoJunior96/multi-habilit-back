<?php

namespace App\Http\Controllers;

use App\Http\Requests\MedicoRequest;
use App\Models\Medico;
use Illuminate\Support\Facades\Log;

class MedicoController extends Controller
{
    private function getLoggedUserId()
    {
        return auth('api')->check() ? auth('api')->user()->id : 'usuário não autenticado';
    }

    /**
     * Lista todos os médicos.
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            $medicos = Medico::all();
            Log::info('Médicos listados com sucesso', [
                'total' => $medicos->count(),
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

    /**
     * Cria um novo médico.
     * @param  MedicoRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(MedicoRequest $request)
    {
        try {
            $medico = Medico::create($request->validated());

            Log::info('Médico criado com sucesso', [
                'id' => $medico->id,
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

    /**
     * Exibe um médico específico.
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {
            $medico = Medico::find($id);
            if (!$medico) {
                Log::warning('Médico não encontrado', [
                    'id' => $id,
                    'usuario_logado' => $this->getLoggedUserId()
                ]);
                return response()->json(['message' => 'Médico não encontrado.'], 404);
            }
            Log::info('Médico exibido com sucesso', [
                'id' => $id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json($medico, 200);
        } catch (\Exception $e) {
            Log::error('Erro ao exibir médico', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Erro ao exibir médico.'], 500);
        }
    }

    /**
     * Atualiza um médico existente.
     * @param  MedicoRequest $request
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(MedicoRequest $request, $id)
    {
        try {
            $medico = Medico::find($id);
            if (!$medico) {
                Log::warning('Médico não encontrado para atualização', [
                    'id' => $id,
                    'usuario_logado' => $this->getLoggedUserId()
                ]);
                return response()->json(['message' => 'Médico não encontrado.'], 404);
            }
            $medico->update($request->validated());
            Log::info('Médico atualizado com sucesso', [
                'id' => $id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json($medico, 200);
        } catch (\Exception $e) {
            Log::error('Erro ao atualizar médico', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Erro ao atualizar médico.'], 500);
        }
    }

    /**
     * Remove um médico.
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            $medico = Medico::find($id);
            if (!$medico) {
                Log::warning('Médico não encontrado para deleção', [
                    'id' => $id,
                    'usuario_logado' => $this->getLoggedUserId()
                ]);
                return response()->json(['message' => 'Médico não encontrado.'], 404);
            }
            $medico->delete();
            Log::info('Médico deletado com sucesso', [
                'id' => $id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Médico deletado com sucesso.'], 200);
        } catch (\Exception $e) {
            Log::error('Erro ao deletar médico', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Erro ao deletar médico.'], 500);
        }
    }
}
