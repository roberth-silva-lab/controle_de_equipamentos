@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-primary">Lista de Equipamentos</h2>
        <div>
            <a href="{{ route('equipamentos.criar') }}" class="btn btn-success me-2">Novo Equipamento</a>
            <a href="{{ route('equipamentos.relatorio') }}" class="btn btn-info">Relatório</a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <table class="table table-striped table-bordered">
        <thead class="table-primary">
            <tr>
                <th>Nome</th>
                <th>Patrimônio</th>
                <th>Quantidade</th>
                <th>Disponível</th>
                <th>Descrição</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
        </thead>

        <tbody>
            @forelse($equipamentos as $equipamento)
            <tr>
                <td>{{ $equipamento->nome }}</td>
                <td>{{ $equipamento->patrimonio }}</td>
                <td class="text-center">{{ $equipamento->quantidade }}</td>
                <td class="text-center">
                    <span class="badge {{ $equipamento->quantidade_disponivel > 0 ? 'bg-success' : 'bg-danger' }}">
                        {{ $equipamento->quantidade_disponivel }}
                    </span>
                </td>
                <td>{{ Str::limit($equipamento->descricao, 30) ?? '-' }}</td>
                <td>
                    <span class="badge {{ $equipamento->status === 'disponivel' ? 'bg-success' : 'bg-warning' }}">
                        {{ ucfirst($equipamento->status) }}
                    </span>
                </td>
                <td>
                    <a href="{{ route('equipamentos.editar', $equipamento->id) }}" class="btn btn-warning btn-sm">Editar</a>

                    <form action="{{ route('equipamentos.destroy', $equipamento->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('Deseja excluir?')">Excluir</button>
                    </form>
                </td>
            </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center text-muted">Nenhum equipamento cadastrado.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
