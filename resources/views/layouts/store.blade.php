<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Amor em Linhas - Produtos artesanais feitos com amor e carinho. Crochê, tricô e bordados exclusivos.">
    <meta name="theme-color" content="#434a11">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Security Headers -->
    <meta http-equiv="X-Content-Type-Options" content="nosniff">
    <meta http-equiv="X-Frame-Options" content="SAMEORIGIN">
    <meta name="referrer" content="strict-origin-when-cross-origin">

    <title>@yield('title', 'Amor em Linhas')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}?v=2.0">

    @yield('styles')

    <script>
        const temaSalvo = localStorage.getItem('tema') || 'light';
        document.documentElement.setAttribute('data-bs-theme', temaSalvo);
    </script>
</head>
<body>

    @include('layouts.navbar')

    <main class="container mt-4">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>✓</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>!</strong> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="store-footer">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="footer-brand">Amor em Linhas</div>
                    <p class="footer-desc">Peças artesanais feitas com amor e dedicação. Cada produto é único e carrega o carinho de mãos que criam com paixão.</p>
                </div>
                <div class="col-lg-2 col-md-6">
                    <h6 class="footer-title">Navegação</h6>
                    <ul class="footer-links">
                        <li><a href="{{ url('/') }}">Início</a></li>
                        <li><a href="{{ url('/carrinho') }}">Minha Sacola</a></li>
                        @auth
                            <li><a href="{{ url('/profile') }}">Meu Perfil</a></li>
                        @else
                            <li><a href="{{ route('login') }}">Entrar</a></li>
                            <li><a href="{{ route('register') }}">Criar Conta</a></li>
                        @endauth
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h6 class="footer-title">Atendimento</h6>
                    <ul class="footer-links">
                        <li><a href="#">Dúvidas Frequentes</a></li>
                        <li><a href="#">Trocas e Devoluções</a></li>
                        <li><a href="#">Política de Privacidade</a></li>
                        <li><a href="#">Termos de Uso</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h6 class="footer-title">Contato</h6>
                    <ul class="footer-links">
                        <li><a href="#">📧 contato@amoremlinhas.com</a></li>
                        <li><a href="#">📱 WhatsApp</a></li>
                        <li><a href="#">📷 Instagram</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p class="mb-0">© {{ date('Y') }} Amor em Linhas — Todos os direitos reservados.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Cart JS -->
    <script src="{{ asset('js/carrinho.js') }}"></script>

    <script>
        // Atualizar badge do carrinho ao carregar a página
        document.addEventListener('DOMContentLoaded', function() {
            atualizarBadgeCarrinho();
        });
    </script>

    @yield('scripts')
</body>
</html>
