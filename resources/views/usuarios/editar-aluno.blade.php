@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Usuário</h1>

    <form action="{{ route('usuarios.update', $usuario->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Nome</label>
            <input type="text" name="nome" class="form-control" value="{{ $usuario->nome }}" required>
        </div>

        <div class="mb-3">
            <label>Matrícula (4 números)</label>
            <input type="text" name="matricula" maxlength="4" pattern="[0-9]{4}"
                   class="form-control" value="{{ $usuario->matricula }}" required>
        </div>

        <div class="mb-3">
            <label>Tipo</label>
            <select name="tipo" class="form-control" required>
                <option value="aluno" {{ $usuario->tipo == 'aluno' ? 'selected' : '' }}>Aluno</option>
                <option value="professor" {{ $usuario->tipo == 'professor' ? 'selected' : '' }}>Professor</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Atualizar</button>
        <a href="{{ route('usuarios.inicio') }}" class="btn btn-secondary">Voltar</a>
    </form>
</div>
@endsection
