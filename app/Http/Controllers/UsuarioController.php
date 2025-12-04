<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    public function index()
    {
        $usuarios = Usuario::all();
        return view('usuarios.inicio', compact('usuarios'));
    }

    public function create()
    {
        return view('usuarios.criar-aluno');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'matricula' => 'required|digits:4|unique:usuarios',
            'tipo' => 'required|in:aluno,professor',
        ]);

        Usuario::create($request->all());
        return redirect()->route('usuarios.inicio');
    }

    public function edit($id)
    {
        $usuario = Usuario::findOrFail($id);
        return view('usuarios.editar-aluno', compact('usuario'));
    }

    public function update(Request $request, $id)
    {
        $usuario = Usuario::findOrFail($id);

        $request->validate([
            'nome' => 'required|string|max:255',
            'matricula' => 'required|digits:4|unique:usuarios,matricula,' . $usuario->id,
            'tipo' => 'required|in:aluno,professor',
        ]);

        $usuario->update($request->all());
        return redirect()->route('usuarios.inicio'); 
    }

    public function destroy($id)
    {
        Usuario::destroy($id);
        return redirect()->route('usuarios.inicio'); 
    }

    public function relatorio(Request $request)
    {
        $filtro = $request->input('tipo');

        $usuarios = Usuario::when($filtro, function ($query) use ($filtro) {
            return $query->where('tipo', $filtro);
        })->get();

        return view('usuarios.relatorio', compact('usuarios', 'filtro'));
    }
}
