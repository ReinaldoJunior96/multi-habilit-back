<?php

namespace App\Http\Controllers;

use App\Http\Requests\AgendamentoRequest;
use App\Models\Agendamento;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;
use Exception;

class AgendamentoController extends Controller
{
    private function getLoggedUserId()
    {
        return auth('api')->check() ? auth('api')->user()->id : 'usuário não autenticado';
    }

    public function index()
    {
        try {
            $agendamentos = Agendamento::all();

            Log::info('Agendamentos listados com sucesso', [
                'usuario_logado' => $this->getLoggedUserId(),
                'quantidade' => $agendamentos->count()
            ]);

            return response()->json($agendamentos, 200);
        } catch (Exception $e) {
            Log::error('Erro ao listar agendamentos', [
                'exception_message' => $e->getMessage(),
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Erro ao listar agendamentos.'], 500);
        }
    }

    public function show($id)
    {
        try {
            $agendamento = Agendamento::findOrFail($id);

            Log::info("Agendamento {$id} encontrado com sucesso", [
                'usuario_logado' => $this->getLoggedUserId()
            ]);

            return response()->json($agendamento, 200);
        } catch (ModelNotFoundException $e) {
            Log::warning("Agendamento {$id} não encontrado", [
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Agendamento não encontrado.'], 404);
        } catch (Exception $e) {
            Log::error("Erro ao buscar agendamento", [
                'exception_message' => $e->getMessage(),
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Erro ao buscar agendamento.'], 500);
        }
    }

    public function store(AgendamentoRequest $request)
    {
        try {
            $agendamento = Agendamento::create($request->validated());

            Log::info("Agendamento criado com sucesso", [
                'id' => $agendamento->id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);

            return response()->json($agendamento, 201);
        } catch (Exception $e) {
            Log::error("Erro ao criar agendamento", [
                'exception_message' => $e->getMessage(),
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Erro ao criar agendamento.'], 500);
        }
    }

    public function update(AgendamentoRequest $request, $id)
    {
        try {
            $agendamento = Agendamento::findOrFail($id);
            $agendamento->update($request->validated());

            Log::info("Agendamento atualizado com sucesso", [
                'id' => $agendamento->id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);

            return response()->json($agendamento, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Agendamento não encontrado.'], 404);
        } catch (Exception $e) {
            Log::error("Erro ao atualizar agendamento", [
                'exception_message' => $e->getMessage(),
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Erro ao atualizar agendamento.'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $agendamento = Agendamento::findOrFail($id);
            $agendamento->delete();

            Log::info("Agendamento deletado com sucesso", [
                'id' => $id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);

            return response()->json(['message' => 'Agendamento deletado com sucesso.'], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Agendamento não encontrado.'], 404);
        } catch (Exception $e) {
            Log::error("Erro ao deletar agendamento", [
                'exception_message' => $e->getMessage(),
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Erro ao deletar agendamento.'], 500);
        }
    }
}
