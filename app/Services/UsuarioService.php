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
        return response()->json(Usuario::all(), 200);
    }

    public function getUsuarioById($id)
    {

        $usuario = Usuario::with('medico', 'paciente', 'atendente')->where('id',$id)->first();

        return response()->json($usuario, 200);
    }

    /**
     *  @OA\Post(
     *      path="/api/usuarios",
     *      summary="Cadastra um novo usuário",
     *      tags={"Usuário"},
     *      @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="nome_completo", type="string", example="John Doe"),
     *             @OA\Property(property="email", type="string", format="email", example="reinaldojr@example.com"),
     *             @OA\Property(property="password", type="string", format="password", example="password123"),
     *             @OA\Property(property="data_nascimento", type="string", format="date", example="2000-01-01"),
     *             @OA\Property(property="sexo", type="string", example="Masculino"),
     *             @OA\Property(property="rg", type="string", example="123456789"),
     *             @OA\Property(property="cpf", type="string", example="12345678901"),
     *             @OA\Property(property="nome_social", type="string", example="Johnny", nullable=true),
     *             @OA\Property(property="telefone", type="string", example="123456789", nullable=true),
     *             @OA\Property(property="celular", type="string", example="987654321", nullable=true)
     *         )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Usuário criado com sucesso",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="integer", example=1),
     *              @OA\Property(property="nome_completo", type="string", example="John Doe"),
     *              @OA\Property(property="email", type="string", example="reinaldojr@example.com"),
     *              @OA\Property(property="created_at", type="string", format="date-time", example="2024-01-01 12:34:56"),
     *              @OA\Property(property="updated_at", type="string", format="date-time", example="2024-01-01 12:34:56")
     *          )
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Dados de validação incorretos",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Os dados fornecidos são inválidos."),
     *              @OA\Property(property="errors", type="object")
     *          )
     *      )
     *  )
     */
    public function createUsuario($data)
    {
        $usuario = Usuario::withTrashed()->where('email', $data['email'])->orWhere('cpf', $data['cpf'])->first();

        if ($usuario) {
            if ($usuario->trashed()) {
                $usuario->restore();
                $usuario->update([
                    'password' => Hash::make($data['password']),
                    'nome_completo' => $data['nome_completo'],
                    'data_nascimento' => $data['data_nascimento'],
                    'sexo' => $data['sexo'],
                    'rg' => $data['rg'],
                    'cpf' => $data['cpf'],
                    'nome_social' => $data['nome_social'] ?? null,
                    'telefone' => $data['telefone'] ?? null,
                    'celular' => $data['celular'] ?? null,
                ]);
            } else {
                // Se o usuário já existe e não foi deletado, retorna uma mensagem de erro
                return response()->json(['message' => 'Usuário já existe no sistema.'], 409);
            }
        } else {
            // Cria um novo usuário
            $data['password'] = Hash::make($data['password']);
            $usuario = Usuario::create($data);
        }
        return response()->json($usuario, 201);
    }

    public function updateUsuario($data, $id)
    {
        $usuario = Usuario::findOrFail($id);
        $usuario->update($data);
        return response()->json($usuario, 200);
    }

    public function deleteUsuario($id)
    {

        $usuario = Usuario::withTrashed()->findOrFail($id);

        if ($usuario->trashed()) {
            return response()->json(['message' => 'Este usuário já foi excluído.'], 400);
        }

        $usuario->delete();

        return response()->json(['message' => 'Usuário removido com sucesso.'], 200);
    }
}
