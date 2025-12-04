<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Empréstimos</title>

   
    <link 
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
        rel="stylesheet">

    <style>
        
        :root {
            --color-primary: #0d6efd; 
            --color-info:    #174f5a; 
            --color-success: #2b8719; 
            --color-warning: #ffc107;
            --color-danger:  #dc3545; 
            --color-dark:    #212529; 
            --text-on-primary: #ffffff;
            --text-on-warning: #000000;
        }

       
        .table-primary thead, .table-primary th {
            background-color: #0d6efd !important;
            color: #ffffff !important;
        }

        .bg-primary { background-color: #0d6efd !important; color: #ffffff !important; }
        .bg-info    { background-color: #306129    !important; color: #ffffff !important; }
        .bg-success { background-color: #198754 !important; color: #ffffff !important; }
        .bg-warning { background-color: #ffc107 !important; color: #000000 !important; }
        .bg-danger  { background-color: #dc3545  !important; color: #ffffff !important; }

        .btn-success, .btn-success:hover, .btn-success:focus { background-color: #198754 !important; border-color: #198754 !important; }
        .btn-info, .btn-info:hover, .btn-info:focus       { background-color: #bba028 !important; border-color: #0dcaf0 !important; }
        .btn-warning, .btn-warning:hover, .btn-warning:focus { background-color: #ffc107 !important; border-color: #ffc107 !important; color: #000000 !important; }
        .btn-danger, .btn-danger:hover, .btn-danger:focus   { background-color: #dc3545 !important; border-color: #dc3545 !important; }

        .badge.bg-success { background-color: #198754 !important; }
        .badge.bg-warning { background-color: #ffc107 !important; color: #000000 !important; }
        .badge.bg-danger  { background-color: #dc3545 !important; }

       
        .navbar-dark.bg-dark { background-color: #0a0a0a !important; }

       
        @media print {
            .no-print { display: none !important; }
            table { border: 1px solid #000 !important; }
        }
    </style>
</head>
<body>

   
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark no-print">
        <div class="container">

           
            <a class="navbar-brand" href="{{ route('usuarios.inicio') }}">
                Controle de Equipamentos
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" 
                    data-bs-target="#navbarNav" aria-controls="navbarNav" 
                    aria-expanded="false" aria-label="Toggle navigation">

                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">

                <ul class="navbar-nav ms-auto">

                   
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('usuarios*') ? 'active' : '' }}" 
                           href="{{ route('usuarios.inicio') }}">
                           Usuários
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('equipamentos*') ? 'active' : '' }}" 
                           href="{{ route('equipamentos.inicio') }}">
                           Equipamentos
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('emprestimos*') ? 'active' : '' }}" 
                           href="{{ route('emprestimos.inicio') }}">
                           Empréstimos
                        </a>
                    </li>
                </ul>

            </div>
        </div>
    </nav>

    
    <main class="py-4">
        @yield('content')
    </main>

   
    <script 
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
    </script>

</body>
</html>
