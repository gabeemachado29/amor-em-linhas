<nav class="navbar navbar-expand-lg sticky-top">
    <div class="container d-flex flex-wrap align-items-center">
        <!-- Logo -->
        <a class="navbar-brand me-4" href="{{ url('/') }}">
            <span style="font-style: italic; font-weight: 400; opacity: 0.8;">♡</span> Amor em Linhas
        </a>

        <!-- Barra de Pesquisa Desktop -->
        <div class="search-bar-container d-none d-md-block">
            <form class="search-bar-wrapper" action="{{ route('busca') }}" method="GET">
                <input type="text" name="q" class="search-bar" placeholder="Buscar produtos, categorias..." value="{{ request('q') }}" autocomplete="off">
                <button class="search-btn" type="submit" aria-label="Buscar">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                </button>
            </form>
        </div>

        <button class="navbar-toggler ms-auto border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Menu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse mt-3 mt-lg-0" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center gap-1">
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/') }}">Início</a>
                </li>

                @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="menuPerfil" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="me-1" style="vertical-align: -3px;">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                            {{ Str::words(auth()->user()->name, 1, '') }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
                            @if(auth()->user()->tipo_perfil === 'ADMIN')
                                <li><a class="dropdown-item fw-medium py-2" href="{{ url('/admin/dashboard') }}" style="color: var(--primary);">⚙️ Painel Admin</a></li>
                                <li><hr class="dropdown-divider"></li>
                            @endif
                            <li><a class="dropdown-item py-2" href="{{ route('pedidos.index') }}">🛍️ Minhas Compras</a></li>
                            <li><a class="dropdown-item py-2" href="{{ route('profile.edit') }}">👤 Meus Dados</a></li>
                            <li><a class="dropdown-item py-2" href="{{ route('profile.edit') }}#preferencias">⚙️ Preferências</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item py-2 text-danger">🚪 Sair</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">Criar conta</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}" style="font-weight: 600;">Entrar</a>
                    </li>
                @endauth

                <li class="nav-item">
                    <a class="nav-link cart-link" href="{{ url('/carrinho') }}" aria-label="Carrinho de compras">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                            <line x1="3" y1="6" x2="21" y2="6"></line>
                            <path d="M16 10a4 4 0 0 1-8 0"></path>
                        </svg>
                        <span class="cart-badge" id="cartBadge"></span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Barra de Pesquisa Mobile -->
        <div class="search-bar-container d-block d-md-none w-100 mt-2">
            <form class="search-bar-wrapper" action="{{ route('busca') }}" method="GET">
                <input type="text" name="q" class="search-bar" placeholder="Buscar produtos..." value="{{ request('q') }}" autocomplete="off">
                <button class="search-btn" type="submit" aria-label="Buscar">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                </button>
            </form>
        </div>
    </div>
</nav>
