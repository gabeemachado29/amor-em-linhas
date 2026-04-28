<?php
session_start();
require_once "../config/database.php";

// Proteção para apenas ADMIN acessar
if (!isset($_SESSION['user']) || $_SESSION['user']['tipo_perfil'] !== 'ADMIN') {
    header("Location: ../login.php");
    exit();
}

// Lógica para Salvar o Banner
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['banner_arquivo'])) {
    $titulo = $_POST['titulo'];
    $arquivo = $_FILES['banner_arquivo'];

    if ($arquivo['error'] === 0) {
        $extensao = strtolower(pathinfo($arquivo['name'], PATHINFO_EXTENSION));
        $novo_nome = "banner_" . uniqid() . "." . $extensao;
        $diretorio_destino = "../uploads/banners/";

        if (!is_dir($diretorio_destino)) {
            mkdir($diretorio_destino, 0777, true);
        }

        if (move_uploaded_file($arquivo['tmp_name'], $diretorio_destino . $novo_nome)) {
            // Salva o caminho relativo para o index.php encontrar
            $url_banco = "uploads/banners/" . $novo_nome;
            $stmt = $db->prepare("INSERT INTO banners (titulo, imagem_url) VALUES (?, ?)");
            $stmt->execute([$titulo, $url_banco]);
            echo "<script>alert('Banner enviado!'); window.location='gerenciar_banners.php';</script>";
        }
    }
}

// Lógica para Excluir
if (isset($_GET['excluir'])) {
    $id = $_GET['excluir'];
    $stmt = $db->prepare("DELETE FROM banners WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: gerenciar_banners.php");
}

$banners = $db->query("SELECT * FROM banners ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Painel Admin - Banners</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
    <script>
        // Aplica o tema salvo antes de carregar o corpo da página
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
                        <a class="nav-link fw-bold" href="gerenciar_banners.php" style="color: var(--dark-olive) !important;">Gerenciar Banners</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="config_pix.php" style="color: var(--dark-olive) !important;">Configurar PIX</a>
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

    <div class="container mt-5 mb-5">
        
        <div class="card shadow-sm border-0 p-4 mb-5" style="border-radius: 15px;">
            <h4 class="fw-bold mb-4" style="color: var(--dark-olive);">📢 Adicionar Banner Promocional</h4>
            <form method="POST" enctype="multipart/form-data">
                <div class="row g-3 align-items-end">
                    <div class="col-md-5">
                        <label class="fw-bold text-muted mb-1">Título da Promoção (Opcional)</label>
                        <input type="text" name="titulo" class="form-control" placeholder="Ex: Promoção de Inverno">
                    </div>
                    <div class="col-md-5">
                        <label class="fw-bold text-muted mb-1">Arquivo da Arte (Upload)</label>
                        <input type="file" name="banner_arquivo" class="form-control" accept="image/*" required>
                    </div>
                    <div class="col-md-2">
                        <button class="btn w-100 py-2 fw-bold" style="background-color: var(--primary-olive); color: var(--dark-olive); border-radius: 50px;">
                            Upload
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <h4 class="fw-bold mb-3" style="color: var(--dark-olive);">Banners Ativos no Site</h4>
        <div class="row">
            <?php if(count($banners) > 0): ?>
                <?php foreach ($banners as $b): ?>
                    <div class="col-md-4 mb-3">
                        <div class="card shadow-sm border-0" style="border-radius: 15px; overflow: hidden;">
                            <img src="../<?= $b['imagem_url'] ?>" class="card-img-top" style="height: 180px; object-fit: cover;">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <span class="small fw-bold text-muted"><?= htmlspecialchars($b['titulo'] ?: 'Sem título') ?></span>
                                <a href="?excluir=<?= $b['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Excluir este banner?')">Remover</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <p class="text-muted">Nenhum banner cadastrado no momento.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>