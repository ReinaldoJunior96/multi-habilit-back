<?php

namespace App\Services;

use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

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
            $usuarios = $this->usuario->with(['medico', 'paciente'])->get();
            Log::info("Usuário [{$this->getLoggedUserId()}] buscou todos os usuários com sucesso.");
            return response()->json($usuarios, 200);
        } catch (\Exception $e) {
            Log::error("Usuário [{$this->getLoggedUserId()}] erro ao buscar todos os usuários", [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            return response()->json(['message' => 'Erro ao buscar todos os usuários.', 'error' => $e->getMessage(),], 500);
        }
    }

    public function getUsuarioById($id)
    {
        try {
            $usuario = $this->usuario->with(['medico', 'paciente', 'convenios'])->findOrFail($id);
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
        DB::beginTransaction(); // Inicia a transação

        try {
            // Verifica se o usuário já existe
            $usuario = $this->usuario->withTrashed()
                ->where('email', $data['email'])
                ->orWhere('cpf', $data['cpf'])
                ->first();

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
                // Cria o usuário
                $data['password'] = Hash::make($data['password']);
                $usuario = $this->usuario->create($data);
                Log::info("Usuário [{$this->getLoggedUserId()}] criou um novo usuário [ID: {$usuario->id}, Email: {$usuario->email}] com sucesso.");
            }

            // Verifica a role do usuário para cadastro adicional
            if ($data['role'] === 'medico') {
                // Adiciona o ID do usuário ao payload do médico
                $data['medico']['id_usuario'] = $usuario->id;

                // Chama o serviço de cadastro de médico
                $medicoService = app(MedicoService::class);
                $response = $medicoService->createMedico($data['medico']);

                // Verifica se o cadastro do médico falhou
                if ($response->getStatusCode() !== 201) {
                    throw new \Exception('Erro ao cadastrar médico: ' . json_encode($response->getData()));
                }
            }

            if ($data['role'] === 'paciente') {
                // Adiciona o ID do usuário ao payload do médico
                $data['paciente']['id_usuario'] = $usuario->id;

                // Chama o serviço de cadastro de médico
                $pacienteService = app(PacienteService::class);
                $response = $pacienteService->createPaciente($data['paciente']);

                // Verifica se o cadastro do paciente falhou
                if ($response->getStatusCode() !== 201) {
                    throw new \Exception('Erro ao cadastrar paciente: ' . json_encode($response->getData()));
                }
            }

            DB::commit(); // Confirma a transação
            return response()->json($usuario, 201);
        } catch (\Exception $e) {
            DB::rollBack(); // Reverte a transação em caso de erro
            Log::error("Usuário [{$this->getLoggedUserId()}] erro ao criar usuário", [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'input_data' => $data,
            ]);
            return response()->json(['message' => 'Erro ao criar usuário.', 'error' => $e->getMessage()], 500);
        }
    }


    public function updateUsuario(array $data, $id)
    {
        try {
            $usuario = $this->usuario->findOrFail($id);

            // Atualiza a senha separadamente se ela foi enviada
            $this->atualizarSenhaSeNecessario($usuario, $data);

            // Remove o password para evitar sobrescrever com null
            unset($data['password']);

            // Atualiza os demais dados
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

    /**
     * Atualiza a senha do usuário apenas se for enviada
     */
    private function atualizarSenhaSeNecessario($usuario, array &$data)
    {
        if (!empty($data['password'])) {
            $usuario->password = Hash::make($data['password']);
            $usuario->save();
            //dd("Senha recebida:", $data['password'], "Senha criptografada:", Hash::make($data['password']));
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
            'role' => $data['role'] ?? 'paciente',
        ];
    }
}
