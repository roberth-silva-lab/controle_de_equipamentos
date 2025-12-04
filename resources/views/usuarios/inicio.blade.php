@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Lista de Usuários</h2>
        <a href="{{ route('usuarios.create') }}" class="btn btn-success btn-sm">Novo Usuário</a>
        <a href="{{ route('usuarios.relatorio') }}"  class="btn btn-primary">Relatório dos Usuários </a>

    </div>

    <table class="table table-striped table-bordered">
        <thead class="table-primary">
            <tr>
                <th>Nome</th>
                <th>Matrícula</th>
                <th>Tipo</th>
                <th>Data de Cadastro</th>
                <th>Ações</th>
            </tr>
        </thead>

        <tbody>
            @foreach($usuarios as $usuario)
            <tr>
                <td>{{ $usuario->nome }}</td>
                <td>{{ $usuario->matricula }}</td>
                <td>{{ ucfirst($usuario->tipo) }}</td>
                <td>{{ $usuario->created_at->format('d/m/Y H:i') }}</td>
                <td>

                    <a href="{{ route('usuarios.edit', $usuario->id) }}" 
                       class="btn btn-warning btn-sm">Editar</a>

                    <form action="{{ route('usuarios.destroy', $usuario->id) }}" 
                          method="POST" class="d-inline">

                        @csrf
                        @method('DELETE')

                        <button class="btn btn-danger btn-sm"
                                onclick="return confirm('Deseja excluir?')">
                            Excluir
                        </button>

                    </form>

                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
