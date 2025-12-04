@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 style="color:#0d6efd">Relatório de Empréstimos</h1>
        <a href="{{ route('emprestimos.inicio') }}" class="btn" style="background-color:#0d6efd; color:#ffffff; border-color:#0d6efd;">← Voltar</a>
    </div>

    <!-- Estatísticas -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card" style="background-color:#0d6efd; color:#ffffff;">
                <div class="card-body">
                    <h5 class="card-title">Total</h5>
                    <p class="card-text display-4">{{ $total }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card" style="background-color:#198754; color:#ffffff;">
                <div class="card-body">
                    <h5 class="card-title">Devolvidos</h5>
                    <p class="card-text display-4">{{ $devolvidos }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card" style="background-color:#ffc107; color:#000000;">
                <div class="card-body">
                    <h5 class="card-title">Pendentes</h5>
                    <p class="card-text display-4">{{ $pendentes }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card" style="background-color:#dc3545; color:#ffffff;">
                <div class="card-body">
                    <h5 class="card-title">Atrasados</h5>
                    <p class="card-text display-4">{{ $atrasados }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtros -->
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Filtros</h5>
            <form method="GET" action="{{ route('emprestimos.relatorio') }}" class="row g-3">
                <div class="col-md-4">
                    <label for="tipo" class="form-label">Tipo de Usuário:</label>
                    <select name="tipo" id="tipo" class="form-select">
                        <option value="">-- Todos --</option>
                        <option value="aluno" {{ $tipo_filtro === 'aluno' ? 'selected' : '' }}>Aluno</option>
                        <option value="professor" {{ $tipo_filtro === 'professor' ? 'selected' : '' }}>Professor</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="status" class="form-label">Status:</label>
                    <select name="status" id="status" class="form-select">
                        <option value="">-- Todos --</option>
                        <option value="devolvido" {{ $status_filtro === 'devolvido' ? 'selected' : '' }}>Devolvido</option>
                        <option value="pendente" {{ $status_filtro === 'pendente' ? 'selected' : '' }}>Pendente</option>
                    </select>
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-2">Filtrar</button>
                    <a href="{{ route('emprestimos.relatorio') }}" class="btn btn-secondary">Limpar</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabela de Empréstimos -->
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
                    <th>Devolução Real</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($emprestimos as $emp)
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
                                        <span class="badge" style="background-color:#dc3545; color:#ffffff;">ATRASADO</span>
                                @endif
                        </td>
                        <td>
                            @if($emp->data_devolucao)
                                {{ \Carbon\Carbon::parse($emp->data_devolucao)->format('d/m/Y') }}
                            @else
                                <span class="text-muted">--</span>
                            @endif
                        </td>
                        <td>
                            @if($emp->data_devolucao)
                                <span class="badge" style="background-color:#198754; color:#ffffff;">Devolvido</span>
                            @else
                                <span class="badge" style="background-color:#ffc107; color:#000000;">Pendente</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted">Nenhum empréstimo encontrado</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
