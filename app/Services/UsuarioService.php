<?php

namespace App\Services;

use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class UsuarioService
{
    protected $usuario;

    public function __construct(Usuario $usuario)
    {
        $this->usuario = $usuario;
    }

    // Obter o ID do usuário logado
    private function getLoggedUserId()
    {
        return auth('api')->check() ? auth('api')->user()->id : 'usuário não autenticado';
    }

    public function getAllUsuarios()
    {
        try {
            $usuarios = $this->usuario->all();
            Log::info("Usuário [{$this->getLoggedUserId()}] buscou todos os usuários com sucesso.");
            return response()->json($usuarios, 200);
        } catch (\Exception $e) {
            Log::error("Usuário [{$this->getLoggedUserId()}] erro ao buscar todos os usuários", [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);
            return response()->json(['message' => 'Erro ao buscar todos os usuários.'], 500);
        }
    }

    public function getUsuarioById($id)
    {
        try {
            $usuario = $this->usuario->with(['medico', 'paciente', 'atendente'])->findOrFail($id);
            Log::info("Usuário [{$this->getLoggedUserId()}] buscou o usuário [ID: {$id}] com sucesso.");
            return response()->json($usuario, 200);
        } catch (ModelNotFoundException $e) {
            Log::error("Usuário [{$this->getLoggedUserId()}] erro ao buscar usuário [ID: {$id}]: Usuário não encontrado.");
            return response()->json(['message' => 'Usuário não encontrado.'], 404);
        } catch (\Exception $e) {
            Log::error("Usuário [{$this->getLoggedUserId()}] erro ao buscar usuário [ID: {$id}]: " . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);
            return response()->json(['message' => 'Erro ao buscar usuário.'], 500);
        }
    }

    public function createUsuario(array $data)
    {
        try {
            $usuario = $this->usuario->withTrashed()->where('email', $data['email'])->orWhere('cpf', $data['cpf'])->first();

            if ($usuario) {
                if ($usuario->trashed()) {
                    $usuario->restore();
                    $usuario->update($this->formatData($data));
                    Log::info("Usuário [{$this->getLoggedUserId()}] restaurou e atualizou o usuário [ID: {$usuario->id}] com sucesso.");
                } else {
                    Log::warning("Usuário [{$this->getLoggedUserId()}] tentou criar um usuário já existente [Email: {$data['email']}, CPF: {$data['cpf']}].");
                    return response()->json(['message' => 'Usuário já existe no sistema.'], 409);
                }
            } else {
                $data['password'] = Hash::make($data['password']);
                $usuario = $this->usuario->create($data);
                Log::info("Usuário [{$this->getLoggedUserId()}] criou um novo usuário [ID: {$usuario->id}, Email: {$usuario->email}] com sucesso.");
            }

            return response()->json($usuario, 201);
        } catch (\Exception $e) {
            Log::error("Usuário [{$this->getLoggedUserId()}] erro ao criar usuário", [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'input_data' => $data,
            ]);
            return response()->json(['message' => 'Erro ao criar usuário.'], 500);
        }
    }

    public function updateUsuario(array $data, $id)
    {
        try {
            $usuario = $this->usuario->findOrFail($id);
            $usuario->update($data);
            Log::info("Usuário [{$this->getLoggedUserId()}] atualizou o usuário [ID: {$id}] com sucesso.");
            return response()->json($usuario, 200);
        } catch (ModelNotFoundException $e) {
            Log::error("Usuário [{$this->getLoggedUserId()}] erro ao atualizar usuário [ID: {$id}]: Usuário não encontrado.");
            return response()->json(['message' => 'Usuário não encontrado.'], 404);
        } catch (\Exception $e) {
            Log::error("Usuário [{$this->getLoggedUserId()}] erro ao atualizar usuário [ID: {$id}]", [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'input_data' => $data,
            ]);
            return response()->json(['message' => 'Erro ao atualizar usuário.'], 500);
        }
    }

    public function deleteUsuario($id)
    {
        try {
            $usuario = $this->usuario->withTrashed()->findOrFail($id);

            if ($usuario->trashed()) {
                Log::warning("Usuário [{$this->getLoggedUserId()}] tentou excluir um usuário já excluído [ID: {$id}].");
                return response()->json(['message' => 'Este usuário já foi excluído.'], 400);
            }

            $usuario->delete();
            Log::info("Usuário [{$this->getLoggedUserId()}] excluiu o usuário [ID: {$id}] com sucesso.");
            return response()->json(['message' => 'Usuário removido com sucesso.'], 200);
        } catch (ModelNotFoundException $e) {
            Log::error("Usuário [{$this->getLoggedUserId()}] erro ao excluir usuário [ID: {$id}]: Usuário não encontrado.");
            return response()->json(['message' => 'Usuário não encontrado.'], 404);
        } catch (\Exception $e) {
            Log::error("Usuário [{$this->getLoggedUserId()}] erro ao excluir usuário [ID: {$id}]", [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);
            return response()->json(['message' => 'Erro ao excluir usuário.'], 500);
        }
    }

    // Função auxiliar para formatação de dados (reutilização)
    private function formatData(array $data)
    {
        return [
            'password' => Hash::make($data['password']),
            'nome_completo' => $data['nome_completo'],
            'data_nascimento' => $data['data_nascimento'],
            'sexo' => $data['sexo'],
            'rg' => $data['rg'],
            'cpf' => $data['cpf'],
            'nome_social' => $data['nome_social'] ?? null,
            'telefone' => $data['telefone'] ?? null,
            'celular' => $data['celular'] ?? null,
        ];
    }
}
