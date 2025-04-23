<?php

namespace App\Http\Controllers;

use App\Models\FiliacaoPaciente;
use Illuminate\Http\Request;
use App\Http\Requests\FiliacaoPacienteRequest;

class FiliacaoPacienteController extends Controller
{
    public function index()
    {
        return FiliacaoPaciente::all();
    }

    public function store(FiliacaoPacienteRequest $request)
    {
        $filiacao = FiliacaoPaciente::create($request->validated());
        return response()->json($filiacao, 201);
    }

    public function show(FiliacaoPaciente $filiacaoPaciente)
    {
        return $filiacaoPaciente;
    }

    public function update(Request $request, FiliacaoPaciente $filiacaoPaciente)
    {
        $filiacaoPaciente->update($request->all());
        return response()->json($filiacaoPaciente, 200);
    }

    public function destroy(FiliacaoPaciente $filiacaoPaciente)
    {
        $filiacaoPaciente->delete();
        return response()->noContent();
    }
}
