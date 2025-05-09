<?php

namespace App\Http\Controllers;

use App\Models\Atendimento;
use Illuminate\Http\Request;
use App\Http\Requests\AtendimentoRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AtendimentoController extends Controller
{
    private function getLoggedUserId()
    {
        return auth('api')->check() ? auth('api')->user()->id : 'usuário não autenticado';
    }

    public function index()
    {
        try {
            $atendimentos = Atendimento::all();

            Log::info('Atendimentos listados com sucesso', [
                'usuario_logado' => $this->getLoggedUserId()
            ]);

            return response()->json($atendimentos, 200);
        } catch (\Exception $e) {
            Log::error('Erro ao listar atendimentos', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'usuario_logado' => $this->getLoggedUserId()
            ]);

            return response()->json(['message' => 'Erro ao listar atendimentos.'], 500);
        }
    }

    public function store(AtendimentoRequest $request)
    {
        try {
            $atendimento = Atendimento::create($request->validated());

            Log::info('Atendimento criado com sucesso', [
                'atendimento_id' => $atendimento->id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);

            return response()->json($atendimento, 201);
        } catch (\Exception $e) {
            Log::error('Erro ao criar atendimento', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'usuario_logado' => $this->getLoggedUserId()
            ]);

            return response()->json(['message' => 'Erro ao criar atendimento.'], 500);
        }
    }

    public function show($id)
    {
        try {
            $atendimento = Atendimento::findOrFail($id);

            Log::info('Atendimento recuperado com sucesso', [
                'atendimento_id' => $id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);

            return response()->json($atendimento, 200);
        } catch (ModelNotFoundException $e) {
            Log::error('Atendimento não encontrado', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'atendimento_id' => $id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);

            return response()->json(['message' => 'Atendimento não encontrado.'], 404);
        } catch (\Exception $e) {
            Log::error('Erro ao recuperar atendimento', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'atendimento_id' => $id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);

            return response()->json(['message' => 'Erro ao recuperar atendimento.'], 500);
        }
    }

    public function update(AtendimentoRequest $request, $id)
    {
        try {
            $atendimento = Atendimento::findOrFail($id);
            $atendimento->update($request->validated());

            Log::info('Atendimento atualizado com sucesso', [
                'atendimento_id' => $id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);

            return response()->json($atendimento, 200);
        } catch (ModelNotFoundException $e) {
            Log::error('Atendimento não encontrado para atualização', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'atendimento_id' => $id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);

            return response()->json(['message' => 'Atendimento não encontrado.'], 404);
        } catch (\Exception $e) {
            Log::error('Erro ao atualizar atendimento', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'atendimento_id' => $id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);

            return response()->json(['message' => 'Erro ao atualizar atendimento.'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $atendimento = Atendimento::findOrFail($id);
            $atendimento->delete();

            Log::info('Atendimento deletado com sucesso', [
                'atendimento_id' => $id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);

            return response()->json(['message' => 'Atendimento deletado com sucesso.'], 200);
        } catch (ModelNotFoundException $e) {
            Log::error('Atendimento não encontrado para exclusão', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'atendimento_id' => $id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);

            return response()->json(['message' => 'Atendimento não encontrado.'], 404);
        } catch (\Exception $e) {
            Log::error('Erro ao deletar atendimento', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'atendimento_id' => $id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);

            return response()->json(['message' => 'Erro ao deletar atendimento.'], 500);
        }
    }
}
