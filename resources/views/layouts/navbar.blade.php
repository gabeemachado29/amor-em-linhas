<nav class="navbar navbar-expand-lg sticky-top">
    <div class="container d-flex flex-wrap align-items-center">
        <!-- Logo -->
        <a class="navbar-brand me-4" href="{{ url('/') }}">
            Amor em Linhas
        </a>
        
        <!-- Barra de Pesquisa (Falsa) -->
        <div class="search-bar-container d-none d-md-block">
            <form class="d-flex w-100" action="#" method="GET">
                <input type="text" class="search-bar form-control" placeholder="Buscar produtos, marcas e muito mais...">
                <button class="btn bg-white" style="border-left: 1px solid #ddd; margin-left: -40px; z-index: 10; border-radius: 0 2px 2px 0;" type="button">
                    🔍
                </button>
            </form>
        </div>

        <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse mt-3 mt-lg-0" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item me-3">
                    <a class="nav-link" href="{{ url('/') }}">Categorias</a>
                </li>
                
                @auth
                    <li class="nav-item dropdown me-3">
                        <a class="nav-link dropdown-toggle" href="#" id="menuPerfil" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ auth()->user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
                            <li><a class="dropdown-item py-2" href="{{ url('/profile') }}">Meu Perfil</a></li>
                            <li><a class="dropdown-item py-2" href="{{ url('/historico') }}">Minhas Compras</a></li>
                            @if(auth()->user()->tipo_perfil === 'ADMIN')
                                <li><a class="dropdown-item py-2" href="{{ url('/admin/dashboard') }}">Painel Admin</a></li>
                            @endif
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item py-2 text-danger">Sair</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">Crie a sua conta</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Entre</a>
                    </li>
                @endauth

                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/carrinho') }}" style="font-size: 1.2rem;">🛒</a>
                </li>
            </ul>
        </div>

        <!-- Barra de Pesquisa Mobile -->
        <div class="search-bar-container d-block d-md-none w-100 mt-2">
            <form class="d-flex w-100" action="#" method="GET">
                <input type="text" class="search-bar form-control" placeholder="Buscar produtos...">
            </form>
        </div>
    </div>
</nav>
