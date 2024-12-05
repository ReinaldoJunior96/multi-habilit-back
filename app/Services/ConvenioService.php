<?php

namespace App\Services;

use App\Models\Convenio;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class ConvenioService
{
    protected $convenio;

    public function __construct(Convenio $convenio)
    {
        $this->convenio = $convenio;
    }

    private function getLoggedUserId()
    {
        return auth('api')->check() ? auth('api')->user()->id : 'usuário não autenticado';
    }

    // Obter todos os convênios
    public function getAllConvenios()
    {
        try {
            // Carrega convênios com os pacientes associados
            $convenios = $this->convenio->with('pacientes')->get();

            Log::info('Convênios listados com sucesso.', [
                'usuario_logado' => $this->getLoggedUserId()
            ]);

            return $convenios;
        } catch (\Exception $e) {
            Log::error('Erro ao listar convênios.', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'usuario_logado' => $this->getLoggedUserId()
            ]);

            throw $e; // Repropaga a exceção para o controlador tratar
        }
    }

    // Obter um convênio por ID
    public function getConvenioById($id)
    {
        try {
            // Carrega o convênio com os pacientes associados
            $convenio = $this->convenio->with('pacientes')->findOrFail($id);

            Log::info("Convênio ID {$id} encontrado com sucesso.", [
                'usuario_logado' => $this->getLoggedUserId()
            ]);

            return $convenio;
        } catch (ModelNotFoundException $e) {
            Log::error("Convênio não encontrado.", [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'id_convenio' => $id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);

            throw $e; // Repropaga a exceção para o controlador tratar
        } catch (\Exception $e) {
            Log::error('Erro ao buscar convênio.', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'id_convenio' => $id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);

            throw $e; // Repropaga a exceção para o controlador tratar
        }
    }

    // Criar um novo convênio
    public function createConvenio(array $data)
    {
        try {
            // Extrai os pacientes associados, se existirem
            $pacientes = $data['pacientes'] ?? [];

            // Remove o campo 'pacientes' do restante dos dados
            unset($data['pacientes']);

            // Converte arrays para JSON nos campos relevantes
            $data['procedimentos'] = isset($data['procedimentos']) ? json_encode($data['procedimentos']) : null;
            $data['medicamentos'] = isset($data['medicamentos']) ? json_encode($data['medicamentos']) : null;
            $data['taxas'] = isset($data['taxas']) ? json_encode($data['taxas']) : null;
            $data['materiais'] = isset($data['materiais']) ? json_encode($data['materiais']) : null;

            // Cria o convênio
            $convenio = $this->convenio->create($data);

            // Associa os pacientes ao convênio
            if (!empty($pacientes)) {
                $convenio->pacientes()->attach($pacientes);
            }

            Log::info("Convênio criado com sucesso. ID Convênio: {$convenio->id}", [
                'usuario_logado' => $this->getLoggedUserId()
            ]);

            return $convenio;
        } catch (\Exception $e) {
            Log::error('Erro ao criar convênio.', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'input_data' => $data,
                'usuario_logado' => $this->getLoggedUserId()
            ]);

            throw $e; // Repropaga a exceção para o controlador tratar
        }
    }


    // Atualizar um convênio existente
    public function updateConvenio($id, array $data)
    {
        try {
            // Extrai os pacientes associados, se existirem
            $pacientes = isset($data['pacientes']) ? $data['pacientes'] : [];

            // Remove o campo 'pacientes' do restante dos dados
            unset($data['pacientes']);

            // Encontra o convênio
            $convenio = $this->convenio->findOrFail($id);

            // Atualiza os dados do convênio
            $convenio->update($data);

            // Atualiza os pacientes associados
            if (!empty($pacientes)) {
                $convenio->pacientes()->sync($pacientes);
            } else {
                $convenio->pacientes()->detach(); // Remove todos os pacientes associados
            }

            Log::info("Convênio ID {$id} atualizado com sucesso.", [
                'usuario_logado' => $this->getLoggedUserId()
            ]);

            return $convenio;
        } catch (ModelNotFoundException $e) {
            Log::error('Convênio não encontrado para atualização.', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'id_convenio' => $id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);

            throw $e; // Repropaga a exceção para o controlador tratar
        } catch (\Exception $e) {
            Log::error('Erro ao atualizar convênio.', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'id_convenio' => $id,
                'input_data' => $data,
                'usuario_logado' => $this->getLoggedUserId()
            ]);

            throw $e; // Repropaga a exceção para o controlador tratar
        }
    }

    // Deletar um convênio
    public function deleteConvenio($id)
    {
        try {
            // Encontra o convênio
            $convenio = $this->convenio->findOrFail($id);

            // Deleta o convênio
            $convenio->delete();

            Log::info("Convênio ID {$id} deletado com sucesso.", [
                'usuario_logado' => $this->getLoggedUserId()
            ]);

            return true;
        } catch (ModelNotFoundException $e) {
            Log::error('Convênio não encontrado para exclusão.', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'id_convenio' => $id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);

            throw $e; // Repropaga a exceção para o controlador tratar
        } catch (\Exception $e) {
            Log::error('Erro ao deletar convênio.', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'id_convenio' => $id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);

            throw $e; // Repropaga a exceção para o controlador tratar
        }
    }
}
