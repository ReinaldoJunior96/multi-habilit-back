<?php
namespace App\Http\Controllers;
use App\Models\Medico;
use App\Services\MedicoService;
use Illuminate\Http\Request;
class MedicoController extends Controller
{
    protected $medicoService;

    public function __construct(MedicoService $medicoService)
    {
        $this->medicoService = $medicoService;
    }

    public function index()
    {
        return response()->json($this->medicoService->listMedicos());
    }

    public function show($id)
    {
        $medico = $this->medicoService->findMedicoById($id);
        if (!$medico) {
            return response()->json(['error' => 'Médico não encontrado'], 404);
        }
        return response()->json($medico);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'regime_trabalhista' => 'required|integer',
            'carga_horaria' => 'required|integer',
            'cnpj' => 'required|string|size:14',
            'id_usuario' => 'required|exists:usuarios,id',
        ]);

        $medico = $this->medicoService->createMedico($validated);

        return response()->json($medico, 201);
    }

    public function update(Request $request, $id)
    {

        $medico = Medico::findOrFail($id);

        if (!$medico) {
            return response()->json(['error' => 'Médico não encontrado'], 404);
        }

        $validated = $request->validate([
            'regime_trabalhista' => 'required|integer',
            'carga_horaria' => 'required|integer',
            'cnpj' => 'required|string|size:14',
            'id_usuario' => 'required|exists:usuarios,id',
        ]);

       if($this->medicoService->updateMedico($medico, $validated) && $validated){
            return response()->json($medico);
       }

        return response()->json(['error' => 'Erro ao alterar o medico']);





    }

    public function destroy($id)
    {
        $medico = Medico::find($id);
        if (!$medico) {
            return response()->json(['error' => 'Médico não encontrado'], 404);
        }

        $this->medicoService->deleteMedico($medico);

        return response()->json(['message' => 'Médico excluído com sucesso']);
    }
}

