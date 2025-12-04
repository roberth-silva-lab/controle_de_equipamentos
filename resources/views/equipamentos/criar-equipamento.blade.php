@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Novo Equipamento</h1>

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

    <form action="{{ route('equipamentos.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Nome do Equipamento:</label>
            <input type="text" name="nome" class="form-control @error('nome') is-invalid @enderror" 
                   value="{{ old('nome') }}" required>
            @error('nome')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label>Patrimônio (exatamente 12 números):</label>
            <input type="text" name="patrimonio" class="form-control @error('patrimonio') is-invalid @enderror" 
                   value="{{ old('patrimonio') }}" placeholder="000000000001" maxlength="12" 
                   inputmode="numeric" pattern="[0-9]{12}" required>
            <small class="form-text text-muted">
                O patrimônio deve conter exatamente 12 dígitos numéricos
            </small>
            @error('patrimonio')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label>Quantidade:</label>
            <input type="number" name="quantidade" class="form-control @error('quantidade') is-invalid @enderror" 
                   value="{{ old('quantidade', 1) }}" min="1" max="999" required>
            <small class="form-text text-muted">
                Quantidade total de unidades disponíveis (1 a 999)
            </small>
            @error('quantidade')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label>Descrição:</label>
            <textarea name="descricao" class="form-control @error('descricao') is-invalid @enderror" 
                      rows="4" placeholder="Detalhes sobre o equipamento">{{ old('descricao') }}</textarea>
            @error('descricao')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <p class="text-muted"><strong>Status:</strong> Ao cadastrar, o equipamento será marcado como <strong>Disponível</strong></p>
        </div>

        <button type="submit" class="btn btn-primary">Cadastrar</button>
        <a href="{{ route('equipamentos.inicio') }}" class="btn btn-secondary">Voltar</a>
    </form>
</div>
@endsection

