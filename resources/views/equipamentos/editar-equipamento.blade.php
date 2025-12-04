@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Equipamento</h1>

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

    <form action="{{ route('equipamentos.update', $equipamento->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Nome do Equipamento:</label>
            <input type="text" name="nome" class="form-control @error('nome') is-invalid @enderror" 
                   value="{{ old('nome', $equipamento->nome) }}" required>
            @error('nome')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label>Patrimônio (exatamente 12 números):</label>
            <input type="text" name="patrimonio" class="form-control @error('patrimonio') is-invalid @enderror" 
                   value="{{ old('patrimonio', $equipamento->patrimonio) }}" maxlength="12" 
                   inputmode="numeric" pattern="[0-9]{12}" required>
            <small class="form-text text-muted">
                O patrimônio deve conter exatamente 12 dígitos numéricos
            </small>
            @error('patrimonio')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label>Quantidade Total:</label>
                    <input type="number" name="quantidade" class="form-control @error('quantidade') is-invalid @enderror" 
                           value="{{ old('quantidade', $equipamento->quantidade) }}" min="1" max="999" required>
                    <small class="form-text text-muted">Quantidade total de unidades disponíveis</small>
                    @error('quantidade')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label>Quantidade Disponível:</label>
                    <input type="number" class="form-control" 
                           value="{{ $equipamento->quantidade_disponivel }}" disabled>
                    <small class="form-text text-muted">Atualizada automaticamente ao emprestar/devolver</small>
                </div>
            </div>
        </div>

        <div class="mb-3">
            <label>Descrição:</label>
            <textarea name="descricao" class="form-control @error('descricao') is-invalid @enderror" 
                      rows="4">{{ old('descricao', $equipamento->descricao) }}</textarea>
            @error('descricao')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label>Status:</label>
            <select name="status" class="form-control @error('status') is-invalid @enderror" required>
                <option value="">-- Selecione --</option>
                <option value="disponivel" {{ old('status', $equipamento->status) == 'disponivel' ? 'selected' : '' }}>Disponível</option>
                <option value="emprestado" {{ old('status', $equipamento->status) == 'emprestado' ? 'selected' : '' }}>Emprestado</option>
            </select>
            @error('status')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Atualizar</button>
        <a href="{{ route('equipamentos.inicio') }}" class="btn btn-secondary">Voltar</a>
    </form>
</div>
@endsection
