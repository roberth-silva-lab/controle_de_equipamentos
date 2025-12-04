@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Relatório de Equipamentos</h1>

    {{-- FORM DE FILTRO --}}
    <form method="GET" action="{{ route('equipamentos.relatorio') }}" class="mb-4">
        <div class="row g-3">
            <div class="col-md-4">
                <select name="status" class="form-control">
                    <option value="">-- Selecionar Status --</option>
                    <option value="disponivel" {{ $filtro == 'disponivel' ? 'selected' : '' }}>Disponível</option>
                    <option value="emprestado" {{ $filtro == 'emprestado' ? 'selected' : '' }}>Emprestado</option>
                </select>
            </div>

            <div class="col-md-4">
                <button type="submit" class="btn btn-primary">Filtrar</button>
                <a href="{{ route('equipamentos.relatorio') }}" class="btn btn-secondary">Limpar</a>
            </div>
        </div>
    </form>

    {{-- RESULTADOS --}}
    <table class="table table-striped table-bordered">
        <thead class="table-primary">
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Patrimônio</th>
                <th>Quantidade</th>
                <th>Disponível</th>
                <th>Emprestados</th>
                <th>Descrição</th>
                <th>Status</th>
                <th>Data Cadastro</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($equipamentos as $equipamento)
                <tr>
                    <td>{{ $equipamento->id }}</td>
                    <td>{{ $equipamento->nome }}</td>
                    <td>{{ $equipamento->patrimonio }}</td>
                    <td class="text-center"><strong>{{ $equipamento->quantidade }}</strong></td>
                    <td class="text-center">
                        <span class="badge {{ $equipamento->quantidade_disponivel > 0 ? 'bg-success' : 'bg-danger' }}">
                            {{ $equipamento->quantidade_disponivel }}
                        </span>
                    </td>
                    <td class="text-center">
                        {{ $equipamento->quantidade - $equipamento->quantidade_disponivel }}
                    </td>
                    <td>{{ Str::limit($equipamento->descricao, 50) ?? '-' }}</td>
                    <td>
                        <span class="badge {{ $equipamento->status === 'disponivel' ? 'bg-success' : 'bg-danger' }}">
                            {{ ucfirst($equipamento->status) }}
                        </span>
                    </td>
                    <td>{{ $equipamento->created_at->format('d/m/Y') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center text-muted">Nenhum equipamento encontrado.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <a href="{{ route('equipamentos.inicio') }}" class="btn mt-3" style="background-color:#0d6efd; color:#ffffff; border-color:#0d6efd;">Voltar</a>
</div>
@endsection
