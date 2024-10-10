<?php

namespace App\Http\Controllers;

use App\Http\Requests\UsuarioRequest;
use App\Services\UsuarioService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;
use Exception;

class UsuarioController extends Controller
{
    protected $usuarioService;

    public function __construct(UsuarioService $usuarioService)
    {
        $this->usuarioService = $usuarioService;
    }

    private function getLoggedUserId()
    {
        return auth('api')->check() ? auth('api')->user()->id : 'usuário não autenticado';
    }

    public function index()
    {
        try {
            return $this->usuarioService->getAllUsuarios();
        } catch (Exception $e) {
            Log::error('Erro ao buscar usuários', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'usuario_logado' => $this->getLoggedUserId()
            ]);

            return response()->json(['message' => 'Erro ao buscar usuários.', 'error' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        try {
            return $this->usuarioService->getUsuarioById($id);
        } catch (ModelNotFoundException $e) {
            Log::error('Usuário não encontrado', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'usuario_logado' => $this->getLoggedUserId()
            ]);

            return response()->json(['message' => 'Usuário não encontrado.'], 404);
        } catch (Exception $e) {
            Log::error('Erro ao buscar usuário', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'usuario_logado' => $this->getLoggedUserId()
            ]);

            return response()->json(['message' => 'Erro ao buscar usuário.', 'error' => $e->getMessage()], 500);
        }
    }

    public function store(UsuarioRequest $request)
    {
        try {
            $validatedData = $request->validated();
            return $this->usuarioService->createUsuario($validatedData);
        } catch (ValidationException $e) {
            Log::error('Erro de validação ao criar usuário', [
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
            Log::error('Erro ao criar usuário', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'usuario_logado' => $this->getLoggedUserId()
            ]);

            return response()->json(['message' => 'Erro ao criar usuário.', 'error' => $e->getMessage()], 500);
        }
    }

    public function update(UsuarioRequest $request, $id)
    {
        try {
            return $this->usuarioService->updateUsuario($request->all(), $id);
        } catch (ModelNotFoundException $e) {
            Log::error('Usuário não encontrado para atualização', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'usuario_logado' => $this->getLoggedUserId()
            ]);

            return response()->json(['message' => 'Usuário não encontrado.'], 404);
        } catch (ValidationException $e) {
            Log::error('Erro de validação ao atualizar usuário', [
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
        } catch (AuthorizationException $e) {
            Log::error('Acesso negado ao atualizar usuário', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'usuario_logado' => $this->getLoggedUserId()
            ]);

            return response()->json(['message' => 'Acesso negado.'], 403);
        } catch (Exception $e) {
            Log::error('Erro ao atualizar usuário', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'usuario_logado' => $this->getLoggedUserId()
            ]);

            return response()->json(['message' => 'Erro ao atualizar usuário.', 'error' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            return $this->usuarioService->deleteUsuario($id);
        } catch (ModelNotFoundException $e) {
            Log::error('Usuário não encontrado para exclusão', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'usuario_logado' => $this->getLoggedUserId()
            ]);

            return response()->json(['message' => 'Usuário não encontrado.'], 404);
        } catch (AuthorizationException $e) {
            Log::error('Acesso negado ao excluir usuário', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'usuario_logado' => $this->getLoggedUserId()
            ]);

            return response()->json(['message' => 'Acesso negado.'], 403);
        } catch (Exception $e) {
            Log::error('Erro ao excluir usuário', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'usuario_logado' => $this->getLoggedUserId()
            ]);

            return response()->json(['message' => 'Erro ao remover usuário.', 'error' => $e->getMessage()], 500);
        }
    }
}
