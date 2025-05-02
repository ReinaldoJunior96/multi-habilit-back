<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConvenioRequest;
use App\Models\Convenio;
use App\Models\Procedimento;
use App\Services\ConvenioService;
use App\Services\ProcedimentoService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class ConvenioController extends Controller
{
    protected $convenioService;
    protected $procedimentoService;

    public function __construct(ConvenioService $convenioService, ProcedimentoService $procedimentoService)
    {
        $this->convenioService = $convenioService;
        $this->procedimentoService = $procedimentoService;
    }

    private function getLoggedUserId()
    {
        return auth('api')->check() ? auth('api')->user()->id : 'usuário não autenticado';
    }

    public function index()
    {
        try {
            $convenios = Convenio::all();

            Log::info('Convenios listados com sucesso', [
                'usuario_logado' => $this->getLoggedUserId()
            ]);

            return response()->json($convenios, 200);
        } catch (\Exception $e) {
            Log::error('Erro ao listar convenios', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Erro ao listar convenios.'], 500);
        }
    }

    /**
     * Cria um novo convenio.
     */
    public function store(ConvenioRequest $request)
    {
        try {
            $convenio = Convenio::create($request->validated());
            //dd($convenio);
            Log::info('Convenio criado com sucesso', [
                'convenio_id' => $convenio->id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);

            return response()->json($convenio, 201);
        } catch (\Exception $e) {
            Log::error('Erro ao criar convenio', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Erro ao criar convenio.'], 500);
        }
    }

    /**
     * Mostra um convenio específico.
     */
    public function show($id)
    {
        try {
            $convenio = Convenio::findOrFail($id);

            Log::info('Convenio recuperado com sucesso', [
                'convenio_id' => $id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);

            return response()->json($convenio, 200);
        } catch (ModelNotFoundException $e) {
            Log::error('Convenio não encontrado', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'convenio_id' => $id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Convenio não encontrado.'], 404);
        } catch (\Exception $e) {
            Log::error('Erro ao recuperar convenio', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'convenio_id' => $id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Erro ao recuperar convenio.'], 500);
        }
    }

    /**
     * Atualiza um convenio existente.
     */
    public function update(ConvenioRequest $request, $id)
    {
        try {
            $convenio = Convenio::findOrFail($id);

            $convenio->update($request->validated());

            Log::info('Convenio atualizado com sucesso', [
                'convenio_id' => $id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);

            return response()->json($convenio, 200);
        } catch (ModelNotFoundException $e) {
            Log::error('Convenio não encontrado para atualização', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'convenio_id' => $id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Convenio não encontrado.'], 404);
        } catch (\Exception $e) {
            Log::error('Erro ao atualizar convenio', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'convenio_id' => $id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Erro ao atualizar convenio.'], 500);
        }
    }

    /**
     * Deleta um convenio.
     */
    public function destroy($id)
    {
        try {
            $convenio = Convenio::findOrFail($id);
            $convenio->delete();

            Log::info('Convenio deletado com sucesso', [
                'convenio_id' => $id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);

            return response()->json(['message' => 'Convenio deletado com sucesso.'], 200);
        } catch (ModelNotFoundException $e) {
            Log::error('Convenio não encontrado para exclusão', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'convenio_id' => $id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Convenio não encontrado.'], 404);
        } catch (\Exception $e) {
            Log::error('Erro ao deletar convenio', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'convenio_id' => $id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Erro ao deletar convenio.'], 500);
        }
    }

    public function buscarPorConvenio($id)
    {
        try {

            $procedimentos = Procedimento::where("convenio_id", "=", $id)->get();
            //dd($procedimentos);

            // $procedimentos = $convenio->procedimentos;
            Log::info('Procedimentos do convênio listados com sucesso', [
                'convenio_id' => $id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json($procedimentos, 200);
        } catch (ModelNotFoundException $e) {
            Log::error('Convênio não encontrado para listar procedimentos', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'convenio_id' => $id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Convênio não encontrado.'], 404);
        } catch (\Exception $e) {
            Log::error('Erro ao listar procedimentos do convênio', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'convenio_id' => $id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Erro ao listar procedimentos do convênio.'], 500);
        }
    }
}
