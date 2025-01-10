<?php

namespace App\Http\Controllers;

use App\Http\Requests\HorarioRequest;
use App\Models\Horario;
use Illuminate\Http\Request;

class HorarioController extends Controller
{
    // Listar todos os horários
    public function index()
    {
        //dd("testando git pull");
        $horarios = Horario::with('medico.usuario')->get();
        return response()->json($horarios, 200);
    }

    // Mostrar um horário específico
    public function show($id)
    {
        $horario = Horario::with('medicos')->find($id);

        if (!$horario) {
            return response()->json(['message' => 'Horário não encontrado.'], 404);
        }

        return response()->json($horario, 200);
    }

    // Criar um novo horário
    public function store(Request $request)
    {
        // Percorre todos os horários enviados
        foreach ($request->horarios as $horarioBase) {
            $dataInicial = \Carbon\Carbon::parse($horarioBase['data_hora_inicial']);
            $dataFinal = \Carbon\Carbon::parse($horarioBase['data_hora_final']);
            $medicoId = $horarioBase['medico_id'];

            // Verifica se já existe um horário que se sobrepõe
            $conflito = Horario::where('medico_id', $medicoId)
                ->where(function ($query) use ($dataInicial, $dataFinal) {
                    $query->whereBetween('data_hora_inicial', [$dataInicial, $dataFinal])
                        ->orWhereBetween('data_hora_final', [$dataInicial, $dataFinal])
                        ->orWhere(function ($query) use ($dataInicial, $dataFinal) {
                            $query->where('data_hora_inicial', '<=', $dataInicial)
                                ->where('data_hora_final', '>=', $dataFinal);
                        });
                })
                ->exists();

            if ($conflito) {
                // Retorna erro e cancela todo o processo
                return response()->json([
                    'message' => "Já existe um horário registrado para esse médico na data {$dataInicial->format('Y-m-d H:i')}. Nenhum horário foi cadastrado.",
                ], 400);
            }
        }

        // Se não houve conflitos, cria os horários
        $horariosCriados = [];
        foreach ($request->horarios as $horarioBase) {
            $dataInicial = \Carbon\Carbon::parse($horarioBase['data_hora_inicial']);
            $dataFinal = \Carbon\Carbon::parse($horarioBase['data_hora_final']);
            $medicoId = $horarioBase['medico_id'];

            // Gera horários para 1 ano (52 semanas)
            $horarios = [];
            for ($i = 0; $i < 52; $i++) {
                $horarios[] = [
                    'medico_id' => $medicoId,
                    'data_hora_inicial' => $dataInicial->copy()->addWeeks($i)->toDateTimeString(),
                    'data_hora_final' => $dataFinal->copy()->addWeeks($i)->toDateTimeString(),
                ];
            }

            // Salva os horários no banco
            foreach ($horarios as $horario) {
                $horariosCriados[] = Horario::create($horario);
            }
        }

        // Retorna os horários criados
        return response()->json([
            'message' => 'Horários criados com sucesso!',
            'data' => $horariosCriados,
        ], 201);
    }



    // Atualizar um horário existente
    public function update(Request $request, $id)
    {
        $horario = Horario::find($id);

        if (!$horario) {
            return response()->json(['message' => 'Horário não encontrado.'], 404);
        }

        $horario->update($request->validated());
        return response()->json([
            'message' => 'Horário atualizado com sucesso!',
            'data' => $horario
        ], 200);
    }

    // Deletar um horário
    public function destroy($id)
    {
        $horario = Horario::find($id);

        if (!$horario) {
            return response()->json(['message' => 'Horário não encontrado.'], 404);
        }

        $horario->delete();
        return response()->json(['message' => 'Horário deletado com sucesso!'], 200);
    }

    public function buscarMedicosPorHorario($data)
    {

        $horarios = Horario::where('data_hora_inicial', 'like',   $data . '%')->get();
        return response()->json(['message' =>   $horarios], 200);
    }

    public function destroyRecorrente(Request $request)
    {
        //dd($request->all());
        $medicoId = $request->input('medico_id');
        $diaSemana = $request->input('dia_semana'); // Exemplo: "segunda-feira"
        $horarioInicial = $request->input('data_hora_inicial'); // Exemplo: "15:00:00"

        if (!$medicoId || !$diaSemana || !$horarioInicial) {
            return response()->json(['message' => 'Parâmetros inválidos. Certifique-se de enviar "medico_id", "dia_semana" e "data_hora_inicial".'], 400);
        }

        // Mapeia o dia da semana em número (0 = Domingo, 6 = Sábado)
        $diasSemanaMap = [
            'domingo' => 0,
            'segunda-feira' => 1,
            'terca-feira' => 2,
            'quarta-feira' => 3,
            'quinta-feira' => 4,
            'sexta-feira' => 5,
            'sabado' => 6,
        ];

        $diaSemanaNumero = $diasSemanaMap[strtolower($diaSemana)] ?? null;

        if ($diaSemanaNumero === null) {
            return response()->json(['message' => 'Dia da semana inválido.'], 400);
        }

        // Filtra os horários
        $horariosDeletados = Horario::where('medico_id', $medicoId)
            ->where('disponivel', 1) // Apenas horários disponíveis
            ->whereTime('data_hora_inicial', '=', $horarioInicial) // Verifica o horário
            ->get()
            ->filter(function ($horario) use ($diaSemanaNumero) {
                // Verifica se o dia da semana da data_hora_inicial corresponde
                return \Carbon\Carbon::parse($horario->data_hora_inicial)->dayOfWeek === $diaSemanaNumero;
            });

        if ($horariosDeletados->isEmpty()) {
            return response()->json([
                'message' => 'Nenhum horário encontrado para os critérios fornecidos.',
            ], 404);
        }

        // Deleta os horários filtrados
        $totalDeletados = $horariosDeletados->each->delete();

        return response()->json([
            'message' => "Todos os horários recorrentes do médico com ID $medicoId, no dia $diaSemana e horário inicial $horarioInicial foram deletados com sucesso.",
            'total_deletados' => $horariosDeletados->count(),
        ], 200);
    }

    public function uniqueHorarios($id)
    {

        $horarios = Horario::with('medico.usuario')
            ->where('medico_id', $id)
            ->get()
            ->groupBy(function ($horario) {
                // Agrupa pelo horário (hora e minuto) da data_hora_inicial
                return \Carbon\Carbon::parse($horario->data_hora_inicial)->format('H:i');
            })
            ->map(function ($grupo) {
                // Retorna apenas o primeiro registro de cada grupo
                return $grupo->first();
            });
        //dd($horarios);
        return response()->json($horarios->values(), 200);
    }

    public function addFeriado(Request $request)
    {
        // Valida se a data foi fornecida
        $data = $request->input('data');
        $observacao = $request->input('observacao');

        if (!$data || !$observacao) {
            return response()->json(['message' => 'A data e a observação são obrigatórias.'], 400);
        }

        try {
            // Verifica se a data é válida
            $dataFormatada = \Carbon\Carbon::parse($data)->format('Y-m-d');
        } catch (\Exception $e) {
            return response()->json(['message' => 'Formato de data inválido. Use o formato YYYY-MM-DD.'], 400);
        }

        // Busca os horários que têm a mesma data
        $horarios = Horario::whereDate('data_hora_inicial', $dataFormatada)->get();

        if ($horarios->isEmpty()) {
            return response()->json([
                'message' => "Nenhum horário encontrado no dia $dataFormatada.",
            ], 404);
        }

        // Atualiza os horários com a observação antes de deletá-los
        foreach ($horarios as $horario) {
            $horario->update(['observacao' => $observacao]);
            $horario->delete(); // Deleta o registro
        }

        return response()->json([
            'message' => "Horários no dia $dataFormatada foram removidos com sucesso com a observação adicionada.",
            'total_deletados' => $horarios->count(),
        ], 200);
    }

    public function listarDeletados()
    {
        // Obtém os horários deletados
        $horariosDeletados = Horario::onlyTrashed()->get(['data_hora_inicial', 'observacao', 'deleted_at']);

        if ($horariosDeletados->isEmpty()) {
            return response()->json([
                'message' => 'Nenhum horário deletado foi encontrado.',
            ], 404);
        }

        // Retorna os dados
        return response()->json([
            'message' => 'Feriados encontrados.',
            'data' => $horariosDeletados,
        ], 200);
    }
}
