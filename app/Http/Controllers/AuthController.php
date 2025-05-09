<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    /**
     * Realiza o login do usuário e retorna um token JWT.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                Log::warning('Tentativa de login com credenciais inválidas.', ['email' => $credentials['email']]);
                return response()->json(['message' => 'Credenciais inválidas.'], 401);
            }

            Log::info('Login realizado com sucesso.', ['email' => $credentials['email']]);
            return response()->json(['token' => $token], 200);
        } catch (JWTException $e) {
            Log::error('Erro ao gerar o token JWT.', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            return response()->json(['message' => 'Erro ao gerar o token de autenticação.'], 500);
        }
    }

    /**
     * Realiza o logout e invalida o token JWT.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        try {
            $user = auth()->guard('api')->user();
            Log::info('Tentativa de logout.', ['usuario_logado' => $user->id ?? 'desconhecido']);

            JWTAuth::invalidate(JWTAuth::getToken());

            auth()->guard('api')->logout();

            Log::info('Logout realizado com sucesso.', ['usuario_logado' => $user->id ?? 'desconhecido']);
            return response()->json(['message' => 'Logout realizado com sucesso.'], 200);
        } catch (JWTException $e) {
            Log::error('Erro ao invalidar o token JWT.', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            return response()->json(['message' => 'Erro ao realizar logout.'], 500);
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
                Log::warning('Tentativa de acesso sem autenticação.');
                return response()->json(['message' => 'Usuário não autenticado.'], 401);
            }

            Log::info('Informações do usuário autenticado retornadas com sucesso.', ['usuario_id' => $user->id]);
            return response()->json($user, 200);
        } catch (\Exception $e) {
            Log::error('Erro ao obter informações do usuário autenticado.', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            return response()->json(['message' => 'Erro ao obter informações do usuário.'], 500);
        }
    }

    /**
     * Atualiza o token JWT do usuário autenticado.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        try {
            $newToken = JWTAuth::refresh(JWTAuth::getToken());

            Log::info('Token JWT atualizado com sucesso.', ['usuario_logado' => auth()->guard('api')->user()->id ?? 'desconhecido']);
            return response()->json(['token' => $newToken], 200);
        } catch (JWTException $e) {
            Log::error('Erro ao atualizar o token JWT.', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            return response()->json(['message' => 'Erro ao atualizar o token de autenticação.'], 500);
        }
    }
}
