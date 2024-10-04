<?php

namespace App\Services;

use App\Models\Usuario;
use App\Http\Resources\UsuarioResource;
use App\Http\Resources\UsuarioCollection;
use Illuminate\Support\Facades\Hash;

class UsuarioService
{
    public function getAllUsuarios()
    {
        return new UsuarioCollection(Usuario::all());
    }

    public function getUsuarioById($id)
    {
        return new UsuarioResource(Usuario::findOrFail($id));
    }

    public function createUsuario($data)
    {
        $data['password'] = Hash::make($data['password']);

        // Cria o usuário com a senha criptografada
        $usuario = Usuario::create($data);

        return new UsuarioResource($usuario);
    }

    public function updateUsuario($data, $id)
    {
        $usuario = Usuario::findOrFail($id);
        $usuario->update($data);
        return new UsuarioResource($usuario);
    }

    public function deleteUsuario($id)
    {
        $usuario = Usuario::findOrFail($id);
        $usuario->delete();
        return response()->json(['message' => 'Usuário deletado com sucesso']);
    }
}
