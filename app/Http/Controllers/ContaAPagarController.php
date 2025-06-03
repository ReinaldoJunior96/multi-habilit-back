<?php

namespace App\Http\Controllers;

use App\Models\ContaAPagar;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;
use Exception;

class ContaAPagarController extends Controller
{
    /**
     * Retorna o ID do usuário logado ou string padrão.
     */
    private function getLoggedUserId()
    {
        return auth('api')->check() ? auth('api')->user()->id : 'usuário não autenticado';
    }

    /**
     * Lista todas as contas a pagar.
     */
    public function index()
    {
        try {
            $contas = ContaAPagar::all();
            Log::info('Contas a pagar listadas com sucesso', ['usuario_logado' => $this->getLoggedUserId()]);
            return response()->json(['data' => $contas], 200);
        } catch (Exception $e) {
            Log::error('Erro ao listar contas a pagar', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Erro ao listar contas a pagar.'], 500);
        }
    }

    /**
     * Cria uma nova conta a pagar.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'descricao' => 'required|string',
                'categoria' => 'required|string',
                'valor' => 'required|numeric',
                'vencimento' => 'required|date',
                'status' => 'required|string',
                'tipo' => 'required|string',
            ]);
            $conta = ContaAPagar::create($validated);
            Log::info('Conta a pagar criada com sucesso', ['id' => $conta->id, 'usuario_logado' => $this->getLoggedUserId()]);
            return response()->json($conta, 201);
        } catch (ValidationException $e) {
            Log::error('Erro de validação ao criar conta a pagar', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'errors' => $e->errors(),
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json([
                'message' => 'Erro de validação.',
                'errors' => $e->errors(),
            ], 422);
        } catch (Exception $e) {
            Log::error('Erro ao criar conta a pagar', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Erro ao criar conta a pagar.'], 500);
        }
    }

    /**
     * Exibe uma conta a pagar específica.
     */
    public function show($id)
    {
        try {
            $conta = ContaAPagar::findOrFail($id);
            Log::info('Conta a pagar recuperada com sucesso', ['conta_id' => $id, 'usuario_logado' => $this->getLoggedUserId()]);
            return response()->json(['data' => $conta], 200);
        } catch (ModelNotFoundException $e) {
            Log::error('Conta a pagar não encontrada', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'conta_id' => $id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Conta a pagar não encontrada.'], 404);
        } catch (Exception $e) {
            Log::error('Erro ao recuperar conta a pagar', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'conta_id' => $id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Erro ao recuperar conta a pagar.'], 500);
        }
    }

    /**
     * Atualiza uma conta a pagar existente.
     */
    public function update(Request $request, $id)
    {
        try {
            $conta = ContaAPagar::findOrFail($id);
            $validated = $request->validate([
                'descricao' => 'sometimes|required|string',
                'categoria' => 'sometimes|required|string',
                'valor' => 'sometimes|required|numeric',
                'vencimento' => 'sometimes|required|date',
                'status' => 'sometimes|required|string',
                'tipo' => 'sometimes|required|string',
            ]);
            $conta->update($validated);
            Log::info('Conta a pagar atualizada com sucesso', ['conta_id' => $id, 'usuario_logado' => $this->getLoggedUserId()]);
            return response()->json($conta, 200);
        } catch (ModelNotFoundException $e) {
            Log::error('Conta a pagar não encontrada para atualização', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'conta_id' => $id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Conta a pagar não encontrada.'], 404);
        } catch (ValidationException $e) {
            Log::error('Erro de validação ao atualizar conta a pagar', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'errors' => $e->errors(),
                'conta_id' => $id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json([
                'message' => 'Erro de validação.',
                'errors' => $e->errors(),
            ], 422);
        } catch (Exception $e) {
            Log::error('Erro ao atualizar conta a pagar', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'conta_id' => $id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Erro ao atualizar conta a pagar.'], 500);
        }
    }

    /**
     * Remove uma conta a pagar.
     */
    public function destroy($id)
    {
        try {
            $conta = ContaAPagar::findOrFail($id);
            $conta->delete();
            Log::info('Conta a pagar deletada com sucesso', ['conta_id' => $id, 'usuario_logado' => $this->getLoggedUserId()]);
            return response()->json(['message' => 'Conta a pagar deletada com sucesso.'], 200);
        } catch (ModelNotFoundException $e) {
            Log::error('Conta a pagar não encontrada para exclusão', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'conta_id' => $id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Conta a pagar não encontrada.'], 404);
        } catch (Exception $e) {
            Log::error('Erro ao deletar conta a pagar', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'conta_id' => $id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Erro ao deletar conta a pagar.'], 500);
        }
    }
}
