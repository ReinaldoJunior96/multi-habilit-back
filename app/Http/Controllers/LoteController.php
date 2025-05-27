<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LoteController extends Controller
{
    private function getLoggedUserId()
    {
        return auth('api')->check() ? auth('api')->user()->id : 'usuário não autenticado';
    }

    public function index()
    {
        try {
            $lotes = \App\Models\Lote::all();
            Log::info('Lotes listados com sucesso', ['usuario_logado' => $this->getLoggedUserId()]);
            return response()->json(['data' => $lotes], 200);
        } catch (\Exception $e) {
            Log::error('Erro ao listar lotes', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Erro ao listar lotes.'], 500);
        }
    }

    public function store(\App\Http\Requests\LoteRequest $request)
    {
        try {
            $data = $request->validated();
            $idsFichas = $data['ids_fichas'] ?? [];
            $loteNome = $data['lote'] ?? 'LOTE' . now()->format('YmdHis');
    
            if (empty($idsFichas)) {
                return response()->json([
                    'message' => 'É obrigatório informar ao menos uma ficha.'
                ], 422);
            }
    
            $lotesCriados = [];
            $chunks = array_chunk($idsFichas, 100);
            foreach ($chunks as $index => $chunk) {
                $novoLote = \App\Models\Lote::create([
                    'lote' => $loteNome . ($index > 0 ? '-' . ($index + 1) : ''),
                    'ids_fichas' => $chunk,
                ]);
                $lotesCriados[] = $novoLote;
    
                \Log::info('Lote criado com sucesso', [
                    'lote_id' => $novoLote->id,
                    'usuario_logado' => $this->getLoggedUserId()
                ]);
            }
    
            return response()->json(['data' => $lotesCriados], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Erro de validação ao criar lote', [
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
        } catch (\Exception $e) {
            \Log::error('Erro ao criar lote', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Erro ao criar lote.'], 500);
        }
    }
    

    public function show($id)
    {
        try {
            $lote = \App\Models\Lote::findOrFail($id);
            Log::info('Lote recuperado com sucesso', [
                'lote_id' => $id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['data' => $lote], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error('Lote não encontrado', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'lote_id' => $id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Lote não encontrado.'], 404);
        } catch (\Exception $e) {
            Log::error('Erro ao recuperar lote', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'lote_id' => $id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Erro ao recuperar lote.'], 500);
        }
    }

    public function update(\App\Http\Requests\LoteRequest $request, $id)
    {
        try {
            $lote = \App\Models\Lote::findOrFail($id);
            $lote->update($request->validated());
            Log::info('Lote atualizado com sucesso', [
                'lote_id' => $id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json($lote, 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error('Lote não encontrado para atualização', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'lote_id' => $id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Lote não encontrado.'], 404);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Erro de validação ao atualizar lote', [
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
        } catch (\Exception $e) {
            Log::error('Erro ao atualizar lote', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'lote_id' => $id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Erro ao atualizar lote.'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $lote = \App\Models\Lote::findOrFail($id);
            $lote->delete();
            Log::info('Lote deletado com sucesso', [
                'lote_id' => $id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Lote deletado com sucesso.'], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error('Lote não encontrado para exclusão', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'lote_id' => $id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Lote não encontrado.'], 404);
        } catch (\Exception $e) {
            Log::error('Erro ao deletar lote', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'lote_id' => $id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Erro ao deletar lote.'], 500);
        }
    }
}
