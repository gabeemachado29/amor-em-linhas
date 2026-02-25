<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<nav class="navbar navbar-expand-lg sticky-top" style="background-color: var(--primary-olive) !important;">
    <div class="container">
        <a class="navbar-brand fw-bold" href="index.php" style="color: var(--dark-olive) !important;">Amor em Linhas</a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item">
                    <a class="nav-link" href="index.php" style="color: var(--dark-olive) !important;">Produtos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="carrinho.php" style="color: var(--dark-olive) !important;">Carrinho</a>
                </li>
                
                <?php if(isset($_SESSION['user'])): ?>
                    <li class="nav-item dropdown ms-lg-3">
                        <a class="nav-link btn btn-outline-dark d-flex align-items-center px-3 rounded-pill dropdown-toggle" href="#" id="menuPerfil" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Perfil
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
                            <li><a class="dropdown-item py-2" href="perfil.php">👤 Meu Perfil</a></li>
                            <li><a class="dropdown-item py-2" href="historico.php">🛍️ Minhas Compras</a></li>
                            <li><a class="dropdown-item py-2" href="configuracoes.php">⚙️ Configurações</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item py-2 text-danger fw-bold" href="logout.php">Sair</a></li>
                        </ul>
                    </li>
                <?php else: ?>
                    <li class="nav-item ms-lg-2">
                        <a class="nav-link" href="cadastro.php" style="color: var(--dark-olive) !important;">Cadastrar</a>
                    </li>
                    <li class="nav-item d-none d-lg-block">
                        <span class="nav-link opacity-50" style="color: var(--dark-olive) !important;">|</span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php" style="color: var(--dark-olive) !important;">Login</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>