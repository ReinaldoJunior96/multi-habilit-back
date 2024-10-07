<?php

namespace App\Http\Controllers;

use App\Http\Requests\EnderecoRequest;
use App\Services\EnderecoService;
use Illuminate\Http\Request;

class EnderecoController extends Controller
{
    protected $enderecoService;

    public function __construct(EnderecoService $enderecoService)
    {
        $this->enderecoService = $enderecoService;
    }

    // Listar todos os endereços
    public function index()
    {
        $enderecos = $this->enderecoService->getAllEnderecos();
        return response()->json($enderecos, 200);
    }

    // Mostrar um endereço específico
    public function show($id)
    {
        $endereco = $this->enderecoService->getEnderecoById($id);
        return response()->json($endereco, 200);
    }

    // Criar um novo endereço
    public function store(EnderecoRequest $request)
    {

        $endereco = $this->enderecoService->createEndereco($request->validated());

        return response()->json($endereco, 201);
    }

    // Atualizar um endereço
    public function update(EnderecoRequest $request, $id)
    {
        $endereco = $this->enderecoService->updateEndereco($request->validated(), $id);
        return response()->json($endereco, 200);
    }

    // Deletar um endereço
    public function destroy($id)
    {
        $this->enderecoService->deleteEndereco($id);
        return response()->json(null, 204);
    }
}
