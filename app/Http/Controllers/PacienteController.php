<?php

/**
 * Controller responsável por gerenciar as operações relacionadas aos pacientes.
 */

namespace App\Http\Controllers;

use App\Http\Requests\PacienteRequest;
use App\Models\Paciente;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;
use Exception;

class PacienteController extends Controller
{
    /**
     * Obtém o ID do usuário logado.
     *
     * @return int|string
     */
    private function getLoggedUserId()
    {
        return auth('api')->check() ? auth('api')->user()->id : 'usuário não autenticado';
    }

    /**
     * Lista todos os pacientes.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            $pacientes = Paciente::with(['filiacao'])->get();

            Log::info('Pacientes listados com sucesso.', ['usuario_logado' => $this->getLoggedUserId()]);
            return response()->json($pacientes, 200);
        } catch (Exception $e) {
            Log::error('Erro ao buscar pacientes', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Erro ao buscar pacientes.', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Exibe um paciente específico.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {
            $paciente = Paciente::findOrFail($id);
            Log::info('Paciente encontrado com sucesso.', ['id' => $id, 'usuario_logado' => $this->getLoggedUserId()]);
            return response()->json($paciente, 200);
        } catch (ModelNotFoundException $e) {
            Log::error('Paciente não encontrado', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Paciente não encontrado.'], 404);
        } catch (Exception $e) {
            Log::error('Erro ao buscar paciente', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Erro ao buscar paciente.', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Cria um novo paciente.
     *
     * @param PacienteRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(PacienteRequest $request)
    {
        try {
            $validatedData = $request->validated();
            $filiacaoData = $validatedData['filiacao'] ?? null;

            unset($validatedData['filiacao']); // remove antes de salvar paciente

            $paciente = Paciente::create($validatedData);

            if ($filiacaoData) {
                $paciente->filiacao()->create($filiacaoData);
            }

            Log::info('Paciente criado com sucesso.', ['id' => $paciente->id, 'usuario_logado' => $this->getLoggedUserId()]);
            return response()->json($paciente->load('filiacao'), 201);
        } catch (ValidationException $e) {
            Log::error('Erro de validação ao criar paciente', [
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
            Log::error('Erro ao criar paciente', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Erro ao criar paciente.', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Atualiza um paciente existente.
     *
     * @param PacienteRequest $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(PacienteRequest $request, $id)
    {
        try {
            $validatedData = $request->validated();
            $paciente = Paciente::findOrFail($id);
            $paciente->update($validatedData);

            Log::info('Paciente atualizado com sucesso.', ['id' => $id, 'usuario_logado' => $this->getLoggedUserId()]);
            return response()->json($paciente, 200);
        } catch (ModelNotFoundException $e) {
            Log::error('Paciente não encontrado para atualização', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Paciente não encontrado.'], 404);
        } catch (ValidationException $e) {
            Log::error('Erro de validação ao atualizar paciente', [
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
            Log::error('Erro ao atualizar paciente', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Erro ao atualizar paciente.', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove um paciente.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            $paciente = Paciente::findOrFail($id);
            $paciente->delete();

            Log::info('Paciente removido com sucesso.', ['id' => $id, 'usuario_logado' => $this->getLoggedUserId()]);
            return response()->json(['message' => 'Paciente removido com sucesso.'], 200);
        } catch (ModelNotFoundException $e) {
            Log::error('Paciente não encontrado para exclusão', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Paciente não encontrado.'], 404);
        } catch (AuthorizationException $e) {
            Log::error('Acesso negado ao excluir paciente', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Acesso negado.'], 403);
        } catch (Exception $e) {
            Log::error('Erro ao excluir paciente', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Erro ao remover paciente.', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Busca um paciente pelo CPF.
     *
     * @param string $cpf
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchByCpf($cpf)
    {
        try {

            $paciente = Paciente::where('cpf', "=", $cpf)->with(['filiacao', 'endereco', 'fichasMedicas'])->first();
            if (!$paciente) {
                Log::warning('Paciente não encontrado por CPF', [
                    'cpf_buscado' => $cpf,
                    'usuario_logado' => $this->getLoggedUserId()
                ]);
                return response()->json(['message' => 'Paciente não encontrado.'], 404);
            }

            Log::info('Paciente encontrado por CPF com sucesso.', ['cpf' => $cpf, 'usuario_logado' => $this->getLoggedUserId()]);
            return response()->json($paciente, 200);
        } catch (Exception $e) {
            Log::error('Erro ao buscar paciente por CPF', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'cpf_buscado' => $cpf,
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Erro ao buscar paciente por CPF.', 'error' => $e->getMessage()], 500);
        }
    }
}
