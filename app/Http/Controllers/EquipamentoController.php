<?php

namespace App\Http\Controllers;

use App\Models\Equipamento;
use Illuminate\Http\Request;

class EquipamentoController extends Controller
{
    // LISTAR EQUIPAMENTOS PARA CADASTRO
    public function index()
    {
        $equipamentos = Equipamento::all();
        return view('equipamentos.inicio', compact('equipamentos'));
    }

    // TELA DE CADASTRO
    public function create()
    {
        return view('equipamentos.criar-equipamento');
    }

    // SALVAR NOVO EQUIPAMENTO
    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'patrimonio' => 'required|numeric|digits:12|unique:equipamentos,patrimonio',
            'quantidade' => 'required|integer|min:1|max:999',
        ]);

        Equipamento::create([
            'nome' => $request->nome,
            'descricao' => $request->descricao,
            'patrimonio' => $request->patrimonio,
            'quantidade' => $request->quantidade,
            'quantidade_disponivel' => $request->quantidade,
            'status' => 'disponivel',
        ]);

        return redirect()->route('equipamentos.inicio')
                         ->with('success', 'Equipamento cadastrado com sucesso!');
    }

    // TELA DE EDIÇÃO
    public function edit($id)
    {
        $equipamento = Equipamento::findOrFail($id);
        return view('equipamentos.editar-equipamento', compact('equipamento'));
    }

    // ATUALIZAR EQUIPAMENTO
    public function update(Request $request, $id)
    {
        $equipamento = Equipamento::findOrFail($id);

        $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'patrimonio' => 'required|numeric|digits:12|unique:equipamentos,patrimonio,' . $id,
            'status' => 'required|in:disponivel,emprestado',
        ]);

        $equipamento->update($request->all());

        return redirect()->route('equipamentos.inicio')
                         ->with('success', 'Equipamento atualizado com sucesso!');
    }

    // EXCLUIR EQUIPAMENTO
    public function destroy($id)
    {
        Equipamento::findOrFail($id)->delete();

        return redirect()->route('equipamentos.inicio')
                         ->with('success', 'Equipamento excluído com sucesso!');
    }

    // RELATÓRIO DE EQUIPAMENTOS
    public function relatorio(Request $request)
    {
        $filtro = $request->input('status');

        $equipamentos = Equipamento::when($filtro, function ($query) use ($filtro) {
            return $query->where('status', $filtro);
        })->get();

        return view('equipamentos.relatorio-equipamento', compact('equipamentos', 'filtro'));
    }
}
