<?php
namespace App\Http\Controllers;
use App\Http\Requests\MedicoRequest;
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
        return response()->json($this->medicoService->listMedicos(), 200);
    }

    public function show($id)
    {
        $medico = $this->medicoService->findMedicoById($id);
        if (!$medico) {
            return response()->json(['error' => 'Médico não encontrado'], 404);
        }
        return response()->json($medico, 200);
    }

    public function store(MedicoRequest $request)
    {
        if(!Medico::where('id_usuario', $request->get('id_usuario'))->get()->isEmpty()){
            return response()->json(['message'=> 'Médico já atrelado a outro usuário!'], 201);
        }

        $medico = $this->medicoService->createMedico($request->validated());

        return response()->json($medico, 201);
    }

    public function update(MedicoRequest $request, $id)
    {
        $medico = Medico::findOrFail($id);


        $medico->update($request->validated());

        return response()->json($medico, 200);

    }

    public function destroy($id)
    {
        $medico = Medico::find($id);
        if (!$medico) {
            return response()->json(['message' => 'Médico não encontrado.'], 404);
        }

        $this->medicoService->deleteMedico($medico);

        return response()->json(['message' => 'Médico excluído com sucesso.']);
    }
}

