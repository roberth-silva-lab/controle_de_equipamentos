@extends('layouts.app')

@section('content')
<div class="container">
    <h1 style="color: #0d6efd;">Relatório de Usuários</h1>

    {{-- FORM DE FILTRO --}}
    <form method="GET" action="{{ route('usuarios.relatorio') }}" class="mb-4">
        <div class="row g-3">
            <div class="col-md-4">
                <select name="tipo" class="form-control">
                    <option value="">-- Selecionar Tipo --</option>
                    <option value="aluno" {{ $filtro == 'aluno' ? 'selected' : '' }}>Aluno</option>
                    <option value="professor" {{ $filtro == 'professor' ? 'selected' : '' }}>Professor</option>
                </select>
            </div>

            <div class="col-md-4">
                <button type="submit" class="btn btn-primary">Filtrar</button>
                <a href="{{ route('usuarios.relatorio') }}" class="btn btn-secondary">Limpar</a>
            </div>
        </div>
    </form>

    {{-- RESULTADOS --}}
    @forelse ($usuarios as $usuario)
        <div class="card mb-3" style="border: 1px solid #0d6efd;">
            <div class="card-body">
                <p><strong style="color:#0d6efd;">Nome:</strong> {{ $usuario->nome }}</p>
                <p><strong style="color:#0d6efd;">Matrícula:</strong> {{ $usuario->matricula }}</p>
                <p>
                    <strong style="color:#0d6efd;">Tipo:</strong>
                    <span class="badge" style="{{ $usuario->tipo === 'aluno' ? 'background-color:#FF1493; color:#ffffff;' : 'background-color:#ffc107; color:#000000;' }}">
                        {{ ucfirst($usuario->tipo) }}
                    </span>
                </p>
            </div>
        </div>
    @empty
        <p style="color:#0d6efd;">Nenhum usuário encontrado.</p>
    @endforelse

    <a href="{{ route('usuarios.inicio') }}" class="btn mt-3" style="background-color:#FA8072; color:#ffffff; border-color:#FA8072;">Voltar</a>
</div>
@endsection
