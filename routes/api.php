<?php

/**
 * Arquivo de rotas da API.
 *
 * Este arquivo contém todas as definições de rotas da API, organizadas e documentadas
 * seguindo as melhores práticas de Clean Code.
 */

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AgendamentoController,
    AtendimentoController,
    AuthController,
    ConvenioController,
    EnderecoController,
    MedicoController,
    PacienteController,
    UsuarioController,
    ProcedimentoController,
    HorarioController,
    CommandController,
    DeployController,
    FinanceiroController,
    FichaMedicaController,
    FiliacaoPacienteController,
    EspecialidadeController,
    OrcamentoController
};
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use App\Http\Middleware\EnsureApiIsAuthenticated as EnsureApiIsAuthenticatedAlias;
use App\Jobs\ProcessarAgendamentosRecorrentes;

/**
 * Rotas públicas
 */
Route::post('deploy', [DeployController::class, 'deploy']);
Route::post('login', [AuthController::class, 'login']);

/**
 * Rotas protegidas por autenticação
 */
Route::middleware(EnsureApiIsAuthenticatedAlias::class)->group(function () {
    /**
     * Rotas de autenticação
     */
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::get('me', [AuthController::class, 'me']);

    /**
     * Rotas de usuários
     */
    Route::prefix('usuarios')->group(function () {
        Route::post('/', [UsuarioController::class, 'store']);
        Route::get('/', [UsuarioController::class, 'index']);
        Route::get('/{id}', [UsuarioController::class, 'show']);
        Route::delete('/{id}', [UsuarioController::class, 'destroy']);
        Route::put('/edit/{id}', [UsuarioController::class, 'updateUsuario']);
    });

    /**
     * Rotas de médicos
     */
    Route::apiResource('medicos', MedicoController::class);

    /**
     * Rotas de endereços
     */
    Route::apiResource('enderecos', EnderecoController::class);

    /**
     * Rotas de agendamentos
     */
    Route::prefix('agendamentos')->group(function () {
        Route::get('/', [AgendamentoController::class, 'index']);
        Route::get('/{id}', [AgendamentoController::class, 'show']);
        Route::post('/', [AgendamentoController::class, 'store']);
        Route::put('/{id}', [AgendamentoController::class, 'update']);
        Route::delete('/{id}', [AgendamentoController::class, 'destroy']);
    });

    /**
     * Rotas de convênios
     */
    Route::apiResource('convenios', ConvenioController::class);
    Route::get('/convenios/{id}/procedimentos', [ConvenioController::class, 'buscarPorConvenio']);
    /**
     * Rotas de pacientes
     */
    Route::prefix('pacientes')->group(function () {
        Route::get('/', [PacienteController::class, 'index']);
        Route::get('/{id}', [PacienteController::class, 'show']);
        Route::post('/', [PacienteController::class, 'store']);
        Route::put('/{id}', [PacienteController::class, 'update']);
        Route::delete('/{id}', [PacienteController::class, 'destroy']);
        Route::get('/cpf/{cpf}', [PacienteController::class, 'searchByCpf']);
    });

    /**
     * Rotas de procedimentos
     */
    Route::apiResource('procedimentos', ProcedimentoController::class);

    /**
     * Rotas de horários
     */
    Route::prefix('horarios')->group(function () {
        Route::get('/', [HorarioController::class, 'index']);
        Route::post('/', [HorarioController::class, 'store']);
        Route::delete('/{id}', [HorarioController::class, 'destroy']);


        Route::post('/adicionar-feriado', [HorarioController::class, 'addFeriado']);
        Route::get('/feriados', [HorarioController::class, 'listarDeletados']);
        Route::get('/medico/dia/{diaSemana}/{id}', [HorarioController::class, 'buscarHorariosDisponiveis']);
    });

    /**
     * Rotas de atendimentos
     */
    Route::prefix('atendimentos')->group(function () {
        Route::get('/', [AtendimentoController::class, 'index']);
        Route::post('/', [AtendimentoController::class, 'store']);
        Route::get('/{id}', [AtendimentoController::class, 'show']);
        Route::put('/{id}', [AtendimentoController::class, 'update']);
        Route::delete('/{id}', [AtendimentoController::class, 'destroy']);
    });

    /**
     * Rotas financeiras
     */
    Route::prefix('financeiro')->group(function () {
        Route::get('/quantidade/atendimento/convenio/{convenio}', [FinanceiroController::class, 'quantidadeDeAtendimentoPorConvenio']);
        Route::get('/faturamento/convenio/{convenio}', [FinanceiroController::class, 'faturamentoPorConvenio']);
        Route::get('/quantidade/atendimento/terapeuta/{terapeuta}', [FinanceiroController::class, 'quantidadeAtendimentoPorMedico']);
        Route::get('/faturamento/terapeuta/{terapeuta}', [FinanceiroController::class, 'faturamentoPorMedico']);
    });

    /**
     * Rotas de fichas médicas
     */
    Route::apiResource('fichas-medicas', FichaMedicaController::class);

    /**
     * Rotas de filiação de pacientes
     */
    Route::apiResource('filiacao-paciente', FiliacaoPacienteController::class);

    /**
     * Rotas de especialidades
     */
    Route::apiResource('especialidades', EspecialidadeController::class);

    /**
     * Rotas de orçamentos
     */
    Route::apiResource('orcamentos', OrcamentoController::class);
});

/**
 * Rotas auxiliares
 */
Route::get('/commands/fresh-and-seed-users', [CommandController::class, 'freshAndSeedUsers']);
Route::get('/commands/fresh-and-seed-all', [CommandController::class, 'freshAndSeedAll']);
Route::post('/chamada', [App\Http\Controllers\FilaChamadaController::class, 'chamarPaciente']);
Route::get('/executar-job', function () {
    dispatch(new ProcessarAgendamentosRecorrentes());
    return response()->json(['message' => 'Job enviado para execução!'], 200);
});
Route::get('/guia-pdf', function () {
    $dados = json_decode(file_get_contents(storage_path('app/public/fake-guia-data.json')), true);
    $pdf = Pdf::loadView('pdf.guia', ['guia' => $dados]);
    return $pdf->stream('guia.pdf');
});
