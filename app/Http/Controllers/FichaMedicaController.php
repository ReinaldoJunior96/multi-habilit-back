<?php

namespace App\Http\Controllers;

use App\Models\FichaMedica;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Exception;

class FichaMedicaController extends Controller
{
    public function index()
    {
        try {
            $fichas = FichaMedica::with('paciente')->get();

            // Adiciona os dados do convênio manualmente
            $fichas = $fichas->map(function ($ficha) {
                $idConvenio = $ficha->ficha['id_convenio'] ?? null;
                $fichaArray = $ficha->toArray();
                $fichaArray['convenio'] = $idConvenio
                    ? \App\Models\Convenio::find($idConvenio)
                    : null;
                return $fichaArray;
            });

            Log::info('Fichas médicas listadas com sucesso', [
                'usuario_logado' => $this->getLoggedUserId(),
                'quantidade' => $fichas->count()
            ]);

            return response()->json($fichas, 200);
        } catch (Exception $e) {
            Log::error('Erro ao listar fichas médicas', [
                'exception_message' => $e->getMessage(),
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Erro ao listar fichas médicas.'], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'id_paciente' => 'required|exists:pacientes,id',
                'ficha' => 'required|array',
            ]);

            $ficha = FichaMedica::create($data);

            Log::info('Ficha médica criada com sucesso', [
                'id' => $ficha->id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);

            return response()->json($ficha, 201);
        } catch (Exception $e) {
            Log::error('Erro ao criar ficha médica', [
                'exception_message' => $e->getMessage(),
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Erro ao criar ficha médica.'], 500);
        }
    }

    public function show(FichaMedica $fichas_medica)
    {
        try {
            $fichas_medica->load('paciente');

            // Adiciona os dados do convênio manualmente
            $idConvenio = $fichas_medica->ficha['id_convenio'] ?? null;
            $fichaArray = $fichas_medica->toArray();
            $fichaArray['convenio'] = $idConvenio
                ? \App\Models\Convenio::find($idConvenio)
                : null;

            Log::info('Ficha médica encontrada com sucesso', [
                'id' => $fichas_medica->id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);

            return response()->json($fichaArray, 200);
        } catch (Exception $e) {
            Log::error('Erro ao buscar ficha médica', [
                'exception_message' => $e->getMessage(),
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Erro ao buscar ficha médica.'], 500);
        }
    }

    public function update(Request $request, FichaMedica $fichas_medica)
    {
        try {
            $data = $request->validate([
                'ficha' => 'required|array',
            ]);

            $fichas_medica->update($data);

            Log::info('Ficha médica atualizada com sucesso', [
                'id' => $fichas_medica->id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);

            return response()->json($fichas_medica, 200);
        } catch (Exception $e) {
            Log::error('Erro ao atualizar ficha médica', [
                'exception_message' => $e->getMessage(),
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Erro ao atualizar ficha médica.'], 500);
        }
    }

    public function destroy(FichaMedica $fichas_medica)
    {
        try {
            $fichas_medica->delete();

            Log::info('Ficha médica deletada com sucesso', [
                'id' => $fichas_medica->id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);

            return response()->json(null, 204);
        } catch (Exception $e) {
            Log::error('Erro ao deletar ficha médica', [
                'exception_message' => $e->getMessage(),
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Erro ao deletar ficha médica.'], 500);
        }
    }

    private function getLoggedUserId()
    {
        return auth('api')->check() ? auth('api')->user()->id : 'usuário não autenticado';
    }
}
