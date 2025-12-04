@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Empréstimo</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Erros na validação:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('emprestimos.update', $emprestimo->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Usuário:</label>
            <select name="user_id" class="form-control @error('user_id') is-invalid @enderror" required>
                <option value="">-- Selecione um usuário --</option>
                @foreach($usuarios as $usuario)
                    <option value="{{ $usuario->id }}" {{ old('user_id', $emprestimo->user_id) == $usuario->id ? 'selected' : '' }}>
                        {{ $usuario->nome }} ({{ ucfirst($usuario->tipo) }})
                    </option>
                @endforeach
            </select>
            @error('user_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label>Equipamento:</label>
            <select name="equipamento_id" class="form-control @error('equipamento_id') is-invalid @enderror" required>
                <option value="">-- Selecione um equipamento --</option>
                @foreach($equipamentos as $equipamento)
                    <option value="{{ $equipamento->id }}" {{ old('equipamento_id', $emprestimo->equipamento_id) == $equipamento->id ? 'selected' : '' }}>
                        {{ $equipamento->nome }} (Patrimônio: {{ $equipamento->patrimonio }})
                    </option>
                @endforeach
            </select>
            @error('equipamento_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label>Data do Empréstimo:</label>
            <input type="date" name="data_emprestimo" class="form-control @error('data_emprestimo') is-invalid @enderror" 
                   value="{{ old('data_emprestimo', $emprestimo->data_emprestimo) }}" required>
            @error('data_emprestimo')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label>Devolução Prevista:</label>
            <input type="date" name="data_prevista_devolucao" class="form-control @error('data_prevista_devolucao') is-invalid @enderror" 
                   value="{{ old('data_prevista_devolucao', $emprestimo->data_prevista_devolucao) }}" required>
            @error('data_prevista_devolucao')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Atualizar</button>
        <a href="{{ route('emprestimos.inicio') }}" class="btn btn-secondary">Voltar</a>
    </form>
</div>
@endsection
