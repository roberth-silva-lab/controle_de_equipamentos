@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Consultar Empréstimos</h1>
        <div class="btn-group">
            <a href="{{ route('emprestimos.criar') }}" class="btn btn-primary">+ Novo Empréstimo</a>
            <a href="{{ route('emprestimos.relatorio') }}" class="btn btn-info">Relatório</a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session('erro'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert" style="background-color: #dc3545; color: #ffffff;">
            {{ session('erro') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
        </div>
    @endif

    <!-- Filtros -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('emprestimos.inicio') }}" class="row g-3">
                <div class="col-md-3">
                    <label for="tipo_filtro" class="form-label">Tipo de Usuário:</label>
                    <select name="tipo" id="tipo_filtro" class="form-select">
                        <option value="">-- Todos --</option>
                        <option value="aluno" {{ $tipo_filtro === 'aluno' ? 'selected' : '' }}>Aluno</option>
                        <option value="professor" {{ $tipo_filtro === 'professor' ? 'selected' : '' }}>Professor</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="status_filtro" class="form-label">Status:</label>
                    <select name="status" id="status_filtro" class="form-select">
                        <option value="">-- Todos --</option>
                        <option value="pendente">Pendente</option>
                        <option value="devolvido">Devolvido</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="busca" class="form-label">Buscar (Nome/Equipamento):</label>
                    <input type="text" name="busca" id="busca" class="form-control" placeholder="Digte aqui...">
                </div>
                <div class="col-md-3 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-primary">Filtrar</button>
                    <a href="{{ route('emprestimos.inicio') }}" class="btn btn-secondary">Limpar</a>
                </div>
            </form>
        </div>
    </div>

    @if($emprestimos->count())
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="table-primary">
                <tr>
                    <th>Usuário</th>
                    <th>Tipo</th>
                    <th>Equipamento</th>
                    <th>Patrimônio</th>
                    <th>Empréstimo</th>
                    <th>Devolução Prevista</th>
                    <th>Status</th>
                    <th class="text-center">Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($emprestimos as $emp)
                <tr>
                    <td>{{ $emp->usuario->nome }}</td>
                    <td>
                        <span class="badge" style="{{ $emp->usuario->tipo === 'aluno' ? 'background-color: #0dcaf0; color: #ffffff;' : 'background-color: #ffc107; color: #000000;' }}">
                            {{ ucfirst($emp->usuario->tipo) }}
                        </span>
                    </td>
                    <td>{{ $emp->equipamento->nome }}</td>
                    <td>{{ $emp->equipamento->patrimonio }}</td>
                    <td>{{ \Carbon\Carbon::parse($emp->data_emprestimo)->format('d/m/Y') }}</td>
                    <td>
                        {{ \Carbon\Carbon::parse($emp->data_prevista_devolucao)->format('d/m/Y') }}
                        @if(!$emp->data_devolucao && \Carbon\Carbon::parse($emp->data_prevista_devolucao)->isPast())
                            <span class="badge" style="background-color: #dc3545; color: #ffffff;">ATRASADO</span>
                        @endif
                    </td>
                    <td>
                        @if($emp->data_devolucao)
                            <span class="badge" style="background-color: #198754; color: #ffffff;">Devolvido</span>
                        @else
                            <span class="badge" style="background-color: #ffc107; color: #000000;">Pendente</span>
                        @endif
                    </td>
                    <td class="text-center">
                        @if(!$emp->data_devolucao)
                            <a href="{{ route('emprestimos.devolver', $emp->id) }}" 
                               class="btn btn-sm btn-success"
                               onclick="return confirm('Confirmar devolução deste equipamento?')">
                               Devolver
                            </a>
                        @endif
                        
                        <a href="{{ route('emprestimos.editar', $emp->id) }}" class="btn btn-sm btn-primary">
                            Editar
                        </a>

                        <form action="{{ route('emprestimos.destroy', $emp->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Deseja excluir este empréstimo?')" 
                                    class="btn btn-sm btn-danger">
                                Excluir
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
        <div class="alert alert-info text-center">
            Nenhum empréstimo registrado.
        </div>
    @endif
</div>
@endsection
