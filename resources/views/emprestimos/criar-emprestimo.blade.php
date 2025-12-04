@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Novo Empréstimo</h1>

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

    @if (session('erro'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('erro') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form action="{{ route('emprestimos.store') }}" method="POST">
        @csrf

        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label>Tipo de Usuário:</label>
                    <select id="tipo_usuario" class="form-select mb-2">
                        <option value="">-- Todos --</option>
                        <option value="aluno">Aluno (até 15 dias)</option>
                        <option value="professor">Professor (até 30 dias)</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label>Buscar Usuário por Nome:</label>
                    <input type="text" id="busca_usuario" class="form-control" placeholder="Digite o nome...">
                </div>
            </div>
        </div>

        <div class="mb-3">
            <label>Usuário:</label>
            <select name="user_id" id="usuario_select" class="form-select @error('user_id') is-invalid @enderror" required>
                <option value="">-- Selecione um usuário --</option>
                @foreach($usuarios as $usuario)
                    <option value="{{ $usuario->id }}" data-tipo="{{ $usuario->tipo }}" data-nome="{{ strtolower($usuario->nome) }}" 
                            {{ old('user_id') == $usuario->id ? 'selected' : '' }}>
                        {{ $usuario->nome }} ({{ ucfirst($usuario->tipo) }})
                    </option>
                @endforeach
            </select>
            @error('user_id')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label>Equipamento:</label>
            <div class="input-group mb-2">
                <input type="text" id="busca_equipamento" class="form-control" placeholder="Buscar por nome ou patrimônio...">
                <button class="btn btn-outline-secondary" type="button" id="btn_limpar_equip">Limpar</button>
            </div>
            <select name="equipamento_id" id="equipamento_select" class="form-select @error('equipamento_id') is-invalid @enderror" required>
                <option value="">-- Selecione um equipamento disponível --</option>
                @foreach($equipamentos as $equipamento)
                    <option value="{{ $equipamento->id }}" 
                            data-nome="{{ strtolower($equipamento->nome) }}"
                            data-patrimonio="{{ strtolower($equipamento->patrimonio) }}"
                            {{ old('equipamento_id') == $equipamento->id ? 'selected' : '' }}>
                        {{ $equipamento->nome }} (Patrimônio: {{ $equipamento->patrimonio }})
                    </option>
                @endforeach
            </select>
            @error('equipamento_id')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label>Data do Empréstimo:</label>
                    <input type="date" name="data_emprestimo" class="form-control @error('data_emprestimo') is-invalid @enderror" 
                           value="{{ old('data_emprestimo', date('Y-m-d')) }}" required>
                    @error('data_emprestimo')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label>Devolução Prevista:</label>
                    <input type="date" name="data_prevista_devolucao" id="data_prevista" 
                           class="form-control @error('data_prevista_devolucao') is-invalid @enderror" 
                           value="{{ old('data_prevista_devolucao') }}" required>
                    @error('data_prevista_devolucao')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                    <small class="form-text text-muted" id="prazo_info">
                        Selecione um usuário para calcular o prazo
                    </small>
                </div>
            </div>
        </div>

        <div class="alert alert-info">
            <strong>ℹ️ Prazos de Empréstimo:</strong>
            <ul class="mb-0">
                <li>Alunos: até <strong>15 dias</strong></li>
                <li>Professores: até <strong>30 dias</strong></li>
            </ul>
        </div>

        <button type="submit" class="btn btn-primary">Registrar Empréstimo</button>
        <a href="{{ route('emprestimos.inicio') }}" class="btn btn-secondary">Voltar</a>
    </form>
</div>

<script>
    // Filtro por tipo de usuário
    document.getElementById('tipo_usuario').addEventListener('change', function() {
        const tipoSelecionado = this.value;
        const options = document.querySelectorAll('#usuario_select option');
        
        options.forEach(option => {
            if (option.value === '') {
                option.style.display = 'block';
            } else {
                option.style.display = (tipoSelecionado === '' || option.dataset.tipo === tipoSelecionado) ? 'block' : 'none';
            }
        });
    });

    // Busca por nome de usuário
    document.getElementById('busca_usuario').addEventListener('keyup', function() {
        const busca = this.value.toLowerCase();
        const options = document.querySelectorAll('#usuario_select option');
        
        options.forEach(option => {
            if (option.value === '') {
                option.style.display = 'block';
            } else {
                const nome = option.dataset.nome || '';
                const tipoSelecionado = document.getElementById('tipo_usuario').value;
                const matchTipo = tipoSelecionado === '' || option.dataset.tipo === tipoSelecionado;
                const matchNome = nome.includes(busca);
                option.style.display = (matchTipo && matchNome) ? 'block' : 'none';
            }
        });
    });

    // Busca por equipamento (nome ou patrimônio)
    document.getElementById('busca_equipamento').addEventListener('keyup', function() {
        const busca = this.value.toLowerCase();
        const options = document.querySelectorAll('#equipamento_select option');
        
        options.forEach(option => {
            if (option.value === '') {
                option.style.display = 'block';
            } else {
                const nome = option.dataset.nome || '';
                const patrimonio = option.dataset.patrimonio || '';
                const match = nome.includes(busca) || patrimonio.includes(busca);
                option.style.display = match ? 'block' : 'none';
            }
        });
    });

    // Botão limpar busca equipamento
    document.getElementById('btn_limpar_equip').addEventListener('click', function() {
        document.getElementById('busca_equipamento').value = '';
        const options = document.querySelectorAll('#equipamento_select option');
        options.forEach(option => {
            option.style.display = 'block';
        });
    });

    // Atualizar datas sugeridas quando usuário é selecionado
    document.getElementById('usuario_select').addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const tipo = selectedOption.dataset.tipo;
        const dias = tipo === 'aluno' ? 15 : 30;
        
        const dataEmprestimo = document.querySelector('input[name="data_emprestimo"]').value;
        if (dataEmprestimo) {
            const data = new Date(dataEmprestimo);
            data.setDate(data.getDate() + dias);
            const dataFormatada = data.toISOString().split('T')[0];
            document.getElementById('data_prevista').value = dataFormatada;
            document.getElementById('prazo_info').innerHTML = `<strong>${ucFirst(tipo)}</strong> pode emprestar por até ${dias} dias`;
        }
    });

    function ucFirst(str) {
        return str.charAt(0).toUpperCase() + str.slice(1);
    }
</script>
@endsection