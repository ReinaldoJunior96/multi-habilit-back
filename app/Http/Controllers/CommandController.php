<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

class CommandController extends Controller
{
    /**
     * Zera o banco e executa apenas a seeder de usuários.
     */
    public function freshAndSeedUsers()
    {
        try {
            // Zera o banco e executa apenas a seeder de usuários
            Artisan::call('migrate:fresh', ['--force' => true]);
            Log::info('Banco zerado com sucesso.');

            Artisan::call('db:seed', [
                '--class' => 'UsuariosTableSeeder',
                '--force' => true,
            ]);
            Log::info('Seeder de usuários executada com sucesso.');

            return response()->json(['message' => 'Banco zerado e usuários populados com sucesso.'], 200);
        } catch (\Exception $e) {
            Log::error('Erro ao zerar banco e popular usuários.', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            return response()->json(['message' => 'Erro ao zerar banco e popular usuários.', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Zera o banco e executa todas as seeders do DatabaseSeeder.
     */
    public function freshAndSeedAll()
    {
        try {
            // Zera o banco e executa todas as seeders
            Artisan::call('migrate:fresh', ['--force' => true]);
            Log::info('Banco zerado com sucesso.');

            Artisan::call('db:seed', ['--force' => true]);
            Log::info('Todas as seeders executadas com sucesso.');

            return response()->json(['message' => 'Banco zerado e seeders executadas com sucesso.'], 200);
        } catch (\Exception $e) {
            Log::error('Erro ao zerar banco e executar todas as seeders.', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            return response()->json(['message' => 'Erro ao zerar banco e executar todas as seeders.', 'error' => $e->getMessage()], 500);
        }
    }
}
