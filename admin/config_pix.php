<?php
    session_start();
    require "../config/database.php";

    // Segurança: Apenas ADMIN
    if(!isset($_SESSION['user']) || $_SESSION['user']['tipo_perfil'] != 'ADMIN'){
        die("Acesso negado");
    }

    if($_POST){
        $stmt = $db->prepare("REPLACE INTO configuracao_loja 
        (id, chave_pix_destino, nome_beneficiario, cidade_beneficiario)
        VALUES (1, ?, ?, ?)");

        $stmt->execute([
            $_POST['chave'],
            $_POST['nome'],
            $_POST['cidade']
        ]);

        $msg = "Dados do PIX atualizados com sucesso!";
    }

    // Busca dados atuais do PIX
    $config = $db->query("SELECT * FROM configuracao_loja LIMIT 1")->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>Configurar PIX - Amor em Linhas</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="../css/style.css">
        <script>
            const temaSalvo = localStorage.getItem('tema') || 'light';
            document.documentElement.setAttribute('data-bs-theme', temaSalvo);
        </script>
    </head>
    <body class="bg-light">

        <nav class="navbar navbar-expand-lg sticky-top shadow-sm" style="background-color: var(--primary-olive) !important;">
            <div class="container">
                <a class="navbar-brand fw-bold text-uppercase" href="dashboard.php" style="color: var(--dark-olive) !important; letter-spacing: 1px;">
                    ⚙️ Painel Admin
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto align-items-center">
                        <li class="nav-item">
                            <a class="nav-link" href="dashboard.php" style="color: var(--dark-olive) !important;">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="gerenciar_produtos.php" style="color: var(--dark-olive) !important;">Gerenciar Produtos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fw-bold" href="config_pix.php" style="color: var(--dark-olive) !important;">Configurar PIX</a>
                        </li>
                        <li class="nav-item d-none d-lg-block">
                            <span class="nav-link opacity-50" style="color: var(--dark-olive) !important;">|</span>
                        </li>
                        <li class="nav-item ms-lg-2">
                            <a class="nav-link" href="../index.php" target="_blank" style="color: var(--dark-olive) !important;">Ver Loja</a>
                        </li>
                        <li class="nav-item ms-lg-3">
                            <a class="btn btn-danger btn-sm rounded-pill px-3 fw-bold text-white" href="../logout.php">Sair</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container d-flex justify-content-center mt-5 mb-5">
            <div class="card shadow-sm border-0 p-4 w-100" style="max-width: 500px; border-radius: 15px;">
                <h4 class="fw-bold mb-4 text-center" style="color: var(--dark-olive);">💲 Conta Bancária (PIX)</h4>
                
                <?php if(isset($msg)) echo "<div class='alert alert-success alert-dismissible fade show'>$msg <button type='button' class='btn-close' data-bs-dismiss='alert'></button></div>"; ?>

                <form method="POST">
                    <div class="mb-3">
                        <label class="fw-bold text-muted mb-1">Chave PIX (Telefone, CPF, E-mail, etc)</label>
                        <input type="text" name="chave" class="form-control" value="<?php echo htmlspecialchars($config['chave_pix_destino'] ?? ''); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="fw-bold text-muted mb-1">Nome do Beneficiário</label>
                        <input type="text" name="nome" class="form-control" value="<?php echo htmlspecialchars($config['nome_beneficiario'] ?? ''); ?>" required>
                    </div>
                    <div class="mb-4">
                        <label class="fw-bold text-muted mb-1">Cidade</label>
                        <input type="text" name="cidade" class="form-control" value="<?php echo htmlspecialchars($config['cidade_beneficiario'] ?? ''); ?>" required>
                    </div>
                    <div class="pt-2 border-top mt-4">
                        <button class="btn w-100 py-2 fw-bold" style="background-color: var(--primary-olive); color: var(--dark-olive); border-radius: 50px;">
                            Salvar Dados do PIX
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>