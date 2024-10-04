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

    public function store(MedicoRequest $request)
    {
        // Pega os dados validados diretamente do MedicoRequest
        $validatedData = $request->validated();
        if(Medico::findOrFail($request->get('id_usuario'))){
            return response()->json(['error'=> 'Usuário já existe!'], 201);
        }
        $medico = $this->medicoService->createMedico($validatedData);

        // Retorna a resposta com o status 201 (Created)
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
            return response()->json(['error' => 'Médico não encontrado'], 404);
        }

        $this->medicoService->deleteMedico($medico);

        return response()->json(['message' => 'Médico excluído com sucesso']);
    }
}

