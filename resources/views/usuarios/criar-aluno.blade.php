@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Novo Usuário</h1>

    <form action="{{ route('usuarios.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Nome:</label>
            <input type="text" name="nome" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Matrícula (4 números):</label>
            <input type="text" name="matricula" maxlength="4" pattern="[0-9]{4}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Tipo:</label>
            <select name="tipo" class="form-control" required>
                <option value="aluno">Aluno</option>
                <option value="professor">Professor</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Salvar</button>
        <a href="{{ route('usuarios.inicio') }}" class="btn btn-secondary">Voltar</a>
    </form>
</div>
@endsection
