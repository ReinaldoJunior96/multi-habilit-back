<?php

use App\Http\Controllers\AgendamentoController;
use App\Http\Controllers\AtendenteController;
use App\Http\Controllers\AtendimentoController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ConvenioController;
use App\Http\Controllers\EnderecoController;
use App\Http\Controllers\MedicoController;
use App\Http\Controllers\PacienteController;
use App\Http\Middleware\EnsureApiIsAuthenticated as EnsureApiIsAuthenticatedAlias;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ProcedimentoController;
use App\Http\Controllers\ConvenioProcedimentoController;
use App\Http\Controllers\HorarioController;
use App\Http\Controllers\CommandController;
use App\Http\Controllers\DeployController;
use App\Http\Controllers\FinanceiroController;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\FichaMedicaController;
use App\Http\Controllers\FiliacaoPacienteController;

Route::post('deploy', [DeployController::class, 'deploy']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware(EnsureApiIsAuthenticatedAlias::class)->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']); // Nova rota para refresh token
    Route::get('me', [AuthController::class, 'me']);
});

Route::middleware(EnsureApiIsAuthenticatedAlias::class)->group(function () {
    Route::post('usuarios', [UsuarioController::class, 'store']);
    Route::get('usuarios', [UsuarioController::class, 'index']);
    Route::get('usuarios/{id}', [UsuarioController::class, 'show']);
    Route::delete('usuarios/{id}', [UsuarioController::class, 'destroy']);
    Route::put('usuarios/edit/{id}', [UsuarioController::class, 'updateUsuario']);
});

Route::middleware(EnsureApiIsAuthenticatedAlias::class)->group(function () {
    Route::get('medicos', [MedicoController::class, 'index']);
    Route::get('medicos/{id}', [MedicoController::class, 'show']);
    Route::post('medicos', [MedicoController::class, 'store']);
    Route::put('medicos/{id}', [MedicoController::class, 'update']);
    Route::delete('medicos/{id}', [MedicoController::class, 'destroy']);
});

Route::middleware(EnsureApiIsAuthenticatedAlias::class)->group(function () {
    Route::get('enderecos', [EnderecoController::class, 'index']);
    Route::get('enderecos/{id}', [EnderecoController::class, 'show']);
    Route::post('enderecos', [EnderecoController::class, 'store']);
    Route::put('enderecos/{id}', [EnderecoController::class, 'update']);
    Route::delete('enderecos/{id}', [EnderecoController::class, 'destroy']);
});


Route::middleware(EnsureApiIsAuthenticatedAlias::class)->group(function () {
    Route::get('agendamentos', [AgendamentoController::class, 'index']);
    Route::get('agendamentos/openai', [AgendamentoController::class, 'agendamentosSimplificado']);
    Route::get('agendamentos/{id}', [AgendamentoController::class, 'show']);
    Route::post('agendamentos', [AgendamentoController::class, 'store']);
    Route::put('agendamentos/{id}', [AgendamentoController::class, 'update']);
    Route::delete('agendamentos/{id}', [AgendamentoController::class, 'destroy']);
});


Route::middleware(EnsureApiIsAuthenticatedAlias::class)->group(function () {
    Route::get('convenios', [ConvenioController::class, 'index']);
    Route::get('convenios/{id}', [ConvenioController::class, 'show']);
    Route::post('convenios', [ConvenioController::class, 'store']);
    Route::put('convenios/{id}', [ConvenioController::class, 'update']);
    Route::delete('convenios/{id}', [ConvenioController::class, 'destroy']);
    Route::get('convenios/{id}/procedimentos', [ConvenioController::class, 'buscarPorConvenio']);
});


Route::middleware(EnsureApiIsAuthenticatedAlias::class)->group(function () {
    Route::get('pacientes', [PacienteController::class, 'index']);
    Route::get('pacientes/{id}', [PacienteController::class, 'show']);
    Route::post('pacientes', [PacienteController::class, 'store']);
    Route::put('pacientes/{id}', [PacienteController::class, 'update']);
    Route::delete('pacientes/{id}', [PacienteController::class, 'destroy']);
    Route::get('/pacientes/cpf/{cpf}', [PacienteController::class, 'searchByCpf']);
});



Route::middleware(EnsureApiIsAuthenticatedAlias::class)->group(function () {
    Route::apiResource('procedimentos', ProcedimentoController::class);
    Route::post('convenio-procedimentos', [ConvenioProcedimentoController::class, 'store']);
});

Route::prefix('horarios')->group(function () {
    Route::post('/', [HorarioController::class, 'store']);
    Route::delete('/{id}', [HorarioController::class, 'destroy']);
    Route::post('/adicionar-feriado', [HorarioController::class, 'addFeriado']);
    Route::get('/feriados', [HorarioController::class, 'listarDeletados']);
    Route::get('/medico/dia/{diaSemana}/{id}', [HorarioController::class, 'buscarHorariosDisponiveis']);
});


Route::get('/commands/fresh-and-seed-users', [CommandController::class, 'freshAndSeedUsers']);

// Executa todas as seeders
Route::get('/commands/fresh-and-seed-all', [CommandController::class, 'freshAndSeedAll']);


Route::post('/chamada', [App\Http\Controllers\FilaChamadaController::class, 'chamarPaciente']);
//Route::post('atendeimento')


Route::prefix('atendimentos')->group(function () {
    Route::get('/', [AtendimentoController::class, 'index']);
    Route::post('/', [AtendimentoController::class, 'store']);
    Route::get('/{id}', [AtendimentoController::class, 'show']);
    Route::put('/{id}', [AtendimentoController::class, 'update']);
    Route::delete('/{id}', [AtendimentoController::class, 'destroy']);
});


Route::prefix('financeiro')->group(function () {
    Route::get('/quantidade/atendimento/convenio/{convenio}', [FinanceiroController::class, 'quantidadeDeAtendimentoPorConvenio']);
    Route::get('/faturamento/convenio/{convenio}', [FinanceiroController::class, 'faturamentoPorConvenio']);

    Route::get('/quantidade/atendimento/terapeuta/{terapeuta}', [FinanceiroController::class, 'quantidadeAtendimentoPorMedico']);
    Route::get('/faturamento/terapeuta/{terapeuta}', [FinanceiroController::class, 'faturamentoPorMedico']);
});


Route::get('/executar-job', function () {
    dispatch(new App\Jobs\ProcessarAgendamentosRecorrentes());

    return response()->json(['message' => 'Job enviado para execução!'], 200);
});


Route::get('/guia-pdf', function () {
    $dados = json_decode(file_get_contents(storage_path('app/public/fake-guia-data.json')), true);
    $pdf = Pdf::loadView('pdf.guia', ['guia' => $dados]);
    return $pdf->stream('guia.pdf');
});


Route::apiResource('fichas-medicas', FichaMedicaController::class);


Route::apiResource('filiacao-paciente', FiliacaoPacienteController::class);

// Route::middleware(EnsureApiIsAuthenticatedAlias::class)->group(function () {
//     Route::post('/convenios/pacientes', [ConvenioPacienteController::class, 'store']);
//     Route::delete('/convenios/pacientes', [ConvenioPacienteController::class, 'remover']);
// });
