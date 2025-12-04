<?php

namespace App\Http\Controllers;

use App\Models\Emprestimo;
use App\Models\Equipamento;
use App\Models\Usuario;
use Illuminate\Http\Request;


class EmprestimoController extends Controller
{
    public function index()
    {
        $tipo_filtro = request('tipo');
        $status_filtro = request('status');
        $busca = request('busca');

        $emprestimos = Emprestimo::with(['usuario', 'equipamento'])
            ->when($tipo_filtro, function ($query) use ($tipo_filtro) {
                return $query->whereHas('usuario', function ($q) use ($tipo_filtro) {
                    $q->where('tipo', $tipo_filtro);
                });
            })
            ->when($status_filtro, function ($query) use ($status_filtro) {
                if ($status_filtro === 'devolvido') {
                    return $query->whereNotNull('data_devolucao');
                } elseif ($status_filtro === 'pendente') {
                    return $query->whereNull('data_devolucao');
                }
                return $query;
            })
            ->when($busca, function ($query) use ($busca) {
                $busca_lower = strtolower($busca);
                return $query->whereHas('usuario', function ($q) use ($busca_lower) {
                    $q->whereRaw('LOWER(nome) LIKE ?', ["%$busca_lower%"]);
                })->orWhereHas('equipamento', function ($q) use ($busca_lower) {
                    $q->whereRaw('LOWER(nome) LIKE ?', ["%$busca_lower%"])
                      ->orWhereRaw('LOWER(patrimonio) LIKE ?', ["%$busca_lower%"]);
                });
            })
            ->get();
        
        return view('emprestimos.inicio', compact('emprestimos', 'tipo_filtro', 'status_filtro', 'busca'));
    }

    public function create()
    {
        $usuarios = Usuario::all();
        $equipamentos = Equipamento::where('status', 'disponivel')->get();

        return view('emprestimos.criar-emprestimo', compact('usuarios', 'equipamentos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:usuarios,id',
            'equipamento_id' => 'required|exists:equipamentos,id',
            'data_emprestimo' => 'required|date',
            'data_prevista_devolucao' => 'required|date|after_or_equal:data_emprestimo',
        ]);

        $equipamento = Equipamento::find($request->equipamento_id);

        // Verificar se há quantidade disponível
        if (!$equipamento->temDisponivel()) {
            return back()->with('erro', 'Nenhuma unidade disponível deste equipamento!');
        }

        // Validar limite de dias baseado no tipo de usuário
        $usuario = Usuario::find($request->user_id);
        $diasEmprestimo = \Carbon\Carbon::parse($request->data_emprestimo)
            ->diffInDays(\Carbon\Carbon::parse($request->data_prevista_devolucao));
        
        $diasPermitidos = $usuario->tipo === 'aluno' ? 15 : 30;
        
        if ($diasEmprestimo > $diasPermitidos) {
            return back()->with('erro', "Limite de empréstimo excedido! " . ucfirst($usuario->tipo) . " podem emprestar por até $diasPermitidos dias.");
        }

        // Criar empréstimo com apenas os campos necessários
        Emprestimo::create([
            'user_id' => $request->user_id,
            'equipamento_id' => $request->equipamento_id,
            'data_emprestimo' => $request->data_emprestimo,
            'data_prevista_devolucao' => $request->data_prevista_devolucao,
        ]);

        // Reduzir quantidade disponível e atualizar status
        $equipamento->emprestar();
        $equipamento->atualizarStatus();

        return redirect()->route('emprestimos.inicio')
                        ->with('success', 'Empréstimo realizado com sucesso!');
    }

    public function edit($id)
    {
        $emprestimo = Emprestimo::findOrFail($id);
        $usuarios = Usuario::all();
        $equipamentos = Equipamento::all();

        return view('emprestimos.editar-emprestimo', compact('emprestimo', 'usuarios', 'equipamentos'));
    }

    public function update(Request $request, $id)
    {
        $emprestimo = Emprestimo::findOrFail($id);

        $request->validate([
            'user_id' => 'required|exists:usuarios,id',
            'equipamento_id' => 'required|exists:equipamentos,id',
            'data_emprestimo' => 'required|date',
            'data_prevista_devolucao' => 'required|date',
        ]);

        $emprestimo->update($request->all());

        return redirect()->route('emprestimos.inicio')
                        ->with('success', 'Empréstimo atualizado com sucesso!');
    }

    public function destroy($id)
    {
        Emprestimo::destroy($id);
        return redirect()->route('emprestimos.inicio')
                        ->with('success', 'Empréstimo excluído com sucesso!');
    }
    public function devolver($id)
    {
        $emprestimo = Emprestimo::findOrFail($id);

        $emprestimo->update([
            'data_devolucao' => now()
        ]);

        // Aumentar quantidade disponível e atualizar status
        $emprestimo->equipamento->devolver();
        $emprestimo->equipamento->atualizarStatus();

        return redirect()->route('emprestimos.inicio')
                        ->with('success', 'Equipamento devolvido com sucesso!');
    }

    public function relatorio()
    {
        $tipo_filtro = request('tipo');
        $status_filtro = request('status');

        $emprestimos = Emprestimo::with(['usuario', 'equipamento'])
            ->when($tipo_filtro, function ($query) use ($tipo_filtro) {
                return $query->whereHas('usuario', function ($q) use ($tipo_filtro) {
                    $q->where('tipo', $tipo_filtro);
                });
            })
            ->when($status_filtro, function ($query) use ($status_filtro) {
                if ($status_filtro === 'devolvido') {
                    return $query->whereNotNull('data_devolucao');
                } elseif ($status_filtro === 'pendente') {
                    return $query->whereNull('data_devolucao');
                }
                return $query;
            })
            ->get();

        $total = $emprestimos->count();
        $devolvidos = $emprestimos->where('data_devolucao', '!=', null)->count();
        $pendentes = $emprestimos->where('data_devolucao', null)->count();
        $atrasados = $emprestimos->filter(function ($emp) {
            return !$emp->data_devolucao && \Carbon\Carbon::parse($emp->data_prevista_devolucao)->isPast();
        })->count();

        return view('emprestimos.relatorio-emprestimos', compact(
            'emprestimos', 'tipo_filtro', 'status_filtro',
            'total', 'devolvidos', 'pendentes', 'atrasados'
        ));
    }
}
