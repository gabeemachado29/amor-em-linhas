<?php
if(session_status() === PHP_SESSION_NONE){
    session_start();
}
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand fw-bold" href="index.php">🧵 Amor em Linhas</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">

                <li class="nav-item">
                    <a class="nav-link" href="index.php">Produtos</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="carrinho.php">🛒 Carrinho</a>
                </li>

                <?php if(isset($_SESSION['usuario_id'])): ?>

                    <!-- PERFIL -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center"
                           href="#"
                           role="button"
                           data-bs-toggle="dropdown">
                            👤 <?php echo $_SESSION['usuario_nome']; ?>
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="perfil.php">✏ Editar Perfil</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="compras.php">📦 Minhas Compras</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="configuracoes.php">⚙ Configurações</a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item text-danger" href="logout.php">🚪 Sair</a>
                            </li>
                        </ul>
                    </li>

                <?php else: ?>

                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Entrar</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="cadastro.php">Cadastrar</a>
                    </li>

                <?php endif; ?>

            </ul>
        </div>
    </div>
</nav>
