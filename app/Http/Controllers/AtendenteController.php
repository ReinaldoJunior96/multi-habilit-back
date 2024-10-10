<?php

namespace App\Http\Controllers;

use App\Http\Requests\AtendenteRequest;
use App\Services\AtendenteService;
use Illuminate\Support\Facades\Log;

class AtendenteController extends Controller
{
    protected $atendenteService;

    public function __construct(AtendenteService $atendenteService)
    {
        $this->atendenteService = $atendenteService;
    }

    private function getLoggedUserId()
    {
        return auth('api')->check() ? auth('api')->user()->id : 'usuário não autenticado';
    }

    // Listar todos os atendentes
    public function index()
    {
        try {
            $atendentes = $this->atendenteService->getAllAtendentes();
            Log::info('Atendentes listados com sucesso', [
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json($atendentes, 200);
        } catch (\Exception $e) {
            Log::error('Erro ao listar atendentes', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['error' => 'Erro ao listar atendentes'], 500);
        }
    }

    // Mostrar um atendente específico
    public function show($id)
    {
        try {
            $atendente = $this->atendenteService->getAtendenteById($id);

            if (!$atendente) {
                Log::warning('Atendente não encontrado', [
                    'atendente_id' => $id,
                    'usuario_logado' => $this->getLoggedUserId()
                ]);
                return response()->json(['error' => 'Atendente não encontrado'], 404);
            }

            Log::info('Atendente mostrado com sucesso', [
                'atendente_id' => $id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json($atendente, 200);
        } catch (\Exception $e) {
            Log::error('Erro ao mostrar atendente', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['error' => 'Erro ao mostrar atendente'], 500);
        }
    }

    // Criar um novo atendente
    public function store(AtendenteRequest $request)
    {
        try {
            $atendente = $this->atendenteService->createAtendente($request->validated());
            Log::info('Atendente criado com sucesso', [
                'atendente_id' => $atendente->id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json($atendente, 201);
        } catch (\Exception $e) {
            Log::error('Erro ao criar atendente', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['error' => 'Erro ao criar atendente'], 500);
        }
    }

    // Atualizar um atendente
    public function update(AtendenteRequest $request, $id)
    {
        try {
            $atendente = $this->atendenteService->updateAtendente($request->validated(), $id);

            if (!$atendente) {
                Log::warning('Atendente não encontrado para atualização', [
                    'atendente_id' => $id,
                    'usuario_logado' => $this->getLoggedUserId()
                ]);
                return response()->json(['error' => 'Atendente não encontrado'], 404);
            }

            Log::info('Atendente atualizado com sucesso', [
                'atendente_id' => $id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json($atendente, 200);
        } catch (\Exception $e) {
            Log::error('Erro ao atualizar atendente', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['error' => 'Erro ao atualizar atendente'], 500);
        }
    }

    // Deletar um atendente
    public function destroy($id)
    {
        try {
            $result = $this->atendenteService->deleteAtendente($id);

            if (!$result) {
                Log::warning('Atendente não encontrado para exclusão', [
                    'atendente_id' => $id,
                    'usuario_logado' => $this->getLoggedUserId()
                ]);
                return response()->json(['error' => 'Atendente não encontrado'], 404);
            }

            Log::info('Atendente deletado com sucesso', [
                'atendente_id' => $id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Atendente deletado com sucesso'], 200);
        } catch (\Exception $e) {
            Log::error('Erro ao deletar atendente', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['error' => 'Erro ao deletar atendente'], 500);
        }
    }
}
