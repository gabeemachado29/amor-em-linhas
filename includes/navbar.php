<?php
if(session_status() === PHP_SESSION_NONE){
    session_start();
}

$lang = $_SESSION['lang'] ?? 'pt';
$textos = require __DIR__ . "/../lang/$lang.php";
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
                    <a class="nav-link" href="index.php">
                        <?php echo $textos['produtos']; ?>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="carrinho.php">
                        🛒 <?php echo $textos['carrinho']; ?>
                    </a>
                </li>

                <?php if(isset($_SESSION['usuario_id'])): ?>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle"
                           href="#"
                           role="button"
                           data-bs-toggle="dropdown">
                            👤 <?php echo $_SESSION['usuario_nome']; ?>
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="perfil.php">Perfil</a></li>
                            <li><a class="dropdown-item" href="configuracoes.php">Configurações</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="logout.php">Sair</a></li>
                        </ul>
                    </li>

                <?php else: ?>

                    <li class="nav-item">
                        <a class="nav-link" href="login.php">
                            <?php echo $textos['login']; ?>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="cadastro.php">
                            <?php echo $textos['cadastro']; ?>
                        </a>
                    </li>

                <?php endif; ?>

            </ul>
        </div>
    </div>
</nav>
