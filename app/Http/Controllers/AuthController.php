<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    /**
     * Login do usuário e geração de token JWT.
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'Credenciais inválidas'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'Não foi possível criar o token'], 500);
        }

        return response()->json(['token' => $token]);
    }

    /**
     * @OA\Info(
     *      version="1.0.0",
     *      title="Back end - Multi-habilit",
     *      description="Documentação da API do projeto",
     *      @OA\Contact(
     *          email="reinaldojunior272@gmail.com"
     *      ),
     *      @OA\License(
     *          name="Apache 2.0",
     *          url="http://www.apache.org/licenses/LICENSE-2.0.html"
     *      )
     * )
     *  @OA\POST(
     *      path="/api/login",
     *      summary="Realiza login",
     *      description="Realiza o login de um usuário cadastrado",
     *      tags={"Test"},
     *      @OA\Parameter(
     *         name="email",
     *         in="query",
     *
     *         description="name",
     *         required=false,
     *      ),
     *     @OA\Parameter(
     *         name="password",
     *         in="query",
     *         description="name",
     *         required=false,
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="{'token': 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vMTI3LjAuMC4xOjgwODEvYXBpL2xvZ2luIiwiaWF0IjoxNzI4MjYyMjU3LCJleHAiOjE3MjgyNjU4NTcsIm5iZiI6MTcyODI2MjI1NywianRpIjoiTk0yWk9Cc2pYY2pyNk9OVSIsInN1YiI6IjQiLCJwcnYiOiI1ODcwODYzZDRhNjJkNzkxNDQzZmFmOTM2ZmMzNjgwMzFkMTEwYzRmIn0.5F8mDnew_KWgBIxvBy46VezLPgm36vcaMZ44oUTuacI'}",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *          )
     *      ),
     *
     *  )
     */
    public function logout()
    {
        try {
            // Invalida o token atual
            JWTAuth::invalidate(JWTAuth::getToken());

            return response()->json(['message' => 'Logout realizado com sucesso']);
        } catch (JWTException $e) {
            return response()->json(['error' => 'Não foi possível invalidar o token'], 500);
        }
    }

    /**
     * Retorna as informações do usuário autenticado.
     */
    public function me()
    {
        return response()->json(auth()->guard('api')->user());
    }
}
