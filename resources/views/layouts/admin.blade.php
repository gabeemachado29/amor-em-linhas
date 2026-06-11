<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#434a11">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin | Amor em Linhas')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}?v=2.0">

    @yield('styles')
</head>
<body class="bg-light">

    <!-- Admin Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: var(--primary-color);">
        <div class="container-fluid px-4">
            <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('admin.dashboard') }}">
                <span style="font-style: italic; font-weight: 400;">♡</span> 
                <strong>Amor em Linhas</strong> <span class="badge bg-light text-dark ms-2">Admin</span>
            </a>
            
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#adminNavbar" aria-controls="adminNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="adminNavbar">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item me-3">
                        <a class="nav-link text-white" href="{{ url('/') }}" target="_blank">
                            🌐 Ver Loja
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white fw-medium" href="#" id="adminMenuPerfil" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ Str::words(auth()->user()->name, 1, '') }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 mt-2">
                            <li><a class="dropdown-item py-2" href="{{ route('profile.edit') }}">👤 Meu Perfil</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item py-2 text-danger">🚪 Sair</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid px-4 mt-4">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 mb-4">
                <div class="card shadow-sm border-0 sticky-top" style="top: 80px;">
                    <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                        <h6 class="fw-bold text-muted text-uppercase" style="font-size: 0.85rem;">Menu Principal</h6>
                    </div>
                    <div class="card-body px-2">
                        <ul class="nav flex-column gap-1">
                            <li class="nav-item">
                                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'text-dark fw-bold bg-light' : 'text-muted' }} rounded px-3 py-2">
                                    📊 Resumo
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.pedidos.index') }}" class="nav-link {{ request()->routeIs('admin.pedidos.*') ? 'text-dark fw-bold bg-light' : 'text-muted' }} rounded px-3 py-2">
                                    🛍️ Pedidos
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.produtos.index') }}" class="nav-link {{ request()->routeIs('admin.produtos.*') ? 'text-dark fw-bold bg-light' : 'text-muted' }} rounded px-3 py-2">
                                    📦 Produtos
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.banners.index') }}" class="nav-link {{ request()->routeIs('admin.banners.*') ? 'text-dark fw-bold bg-light' : 'text-muted' }} rounded px-3 py-2">
                                    🖼️ Banners
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.clientes.index') }}" class="nav-link {{ request()->routeIs('admin.clientes.*') ? 'text-dark fw-bold bg-light' : 'text-muted' }} rounded px-3 py-2">
                                    👥 Clientes
                                </a>
                            </li>
                            <li class="nav-item mt-3">
                                <h6 class="px-3 fw-bold text-muted text-uppercase" style="font-size: 0.85rem;">Sistema</h6>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.configuracoes.edit') }}" class="nav-link {{ request()->routeIs('admin.configuracoes.*') ? 'text-dark fw-bold bg-light' : 'text-muted' }} rounded px-3 py-2">
                                    ⚙️ Configurações
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                        <strong>✓</strong> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
                        <strong>!</strong> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    @yield('scripts')
</body>
</html>
