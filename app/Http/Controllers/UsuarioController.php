<?php

namespace App\Http\Controllers;

use App\Http\Requests\UsuarioRequest;
use App\Services\UsuarioService;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    protected $usuarioService;

    public function __construct(UsuarioService $usuarioService)
    {
        $this->usuarioService = $usuarioService;
    }

    public function index()
    {
        return $this->usuarioService->getAllUsuarios();
    }

    public function show($id)
    {
        return $this->usuarioService->getUsuarioById($id);
    }

    public function store(UsuarioRequest $request)
    {
        $validatedData = $request->validated();

        return $this->usuarioService->createUsuario($validatedData);
    }

    public function update(UsuarioRequest $request, $id)
    {
        return $this->usuarioService->updateUsuario($request->all(), $id);
    }

    public function destroy($id)
    {
        return $this->usuarioService->deleteUsuario($id);
    }
}
