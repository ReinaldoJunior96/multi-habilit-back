<?php

namespace App\Http\Controllers;

use App\Models\FichaMedica;
use Illuminate\Http\Request;

class FichaMedicaController extends Controller
{
    public function index()
    {
        return FichaMedica::all();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'paciente_id' => 'required|exists:pacientes,id',
            'ficha' => 'required|array',
        ]);

        $ficha = FichaMedica::create($data);
        return response()->json($ficha, 201);
    }

    public function show(FichaMedica $fichas_medica)
    {
        return $fichas_medica;
    }

    public function update(Request $request, FichaMedica $fichas_medica)
    {
        $data = $request->validate([
            'ficha' => 'required|array',
        ]);

        $fichas_medica->update($data);
        return response()->json($fichas_medica);
    }

    public function destroy(FichaMedica $fichas_medica)
    {
        $fichas_medica->delete();
        return response()->json(null, 204);
    }
}
