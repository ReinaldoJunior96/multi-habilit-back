<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'Credenciais inválidas'], 401);
            }
        } catch (JWTException $e) {
            Log::error('Erro ao gerar o token JWT: ' . $e->getMessage());
            return response()->json(['error' => 'Não foi possível criar o token'], 500);
        }

        return response()->json(['token' => $token], 200);
    }

    /**
     * Realiza o logout e invalida o token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        try {
            // Invalida o token atual
            JWTAuth::invalidate(JWTAuth::getToken());

            return response()->json(['message' => 'Logout realizado com sucesso'], 200);
        } catch (JWTException $e) {
            Log::error('Erro ao invalidar o token JWT: ' . $e->getMessage());
            return response()->json(['error' => 'Não foi possível invalidar o token'], 500);
        }
    }

    /**
     * Retorna as informações do usuário autenticado.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        try {
            $user = auth()->guard('api')->user();

            if (!$user) {
                return response()->json(['error' => 'Usuário não autenticado'], 401);
            }

            return response()->json($user, 200);
        } catch (\Exception $e) {
            Log::error('Erro ao obter informações do usuário autenticado: ' . $e->getMessage());
            return response()->json(['error' => 'Erro ao obter informações do usuário'], 500);
        }
    }
}
