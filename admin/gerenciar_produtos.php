<?php
session_start();
require "../config/database.php";

// Trava de segurança: Apenas ADMIN entra aqui
if (!isset($_SESSION['user']) || $_SESSION['user']['tipo_perfil'] != 'ADMIN') {
    die("Acesso negado");
}

// AÇÃO: Excluir Produto
if (isset($_GET['excluir'])) {
    $stmt = $db->prepare("DELETE FROM produtos WHERE id = ?");
    $stmt->execute([$_GET['excluir']]);
    header("Location: gerenciar_produtos.php?msg=excluido");
    exit;
}

// AÇÃO: Salvar (Criar ou Atualizar Produto)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $preco = $_POST['preco'];
    $estoque = $_POST['estoque_atual'];
    $id = $_POST['id'] ?? '';

    // Define a imagem atual como padrão (caso não seja enviado um novo arquivo)
    $imagem_final = $_POST['imagem_atual'];

    // Lógica de Upload de Arquivo
    if (isset($_FILES['imagem_arquivo']) && $_FILES['imagem_arquivo']['error'] === 0) {
        $arquivo = $_FILES['imagem_arquivo'];
        $extensao = strtolower(pathinfo($arquivo['name'], PATHINFO_EXTENSION));
        $novo_nome = uniqid() . "." . $extensao;
        $diretorio_destino = "../uploads/";

        // Cria a pasta uploads se não existir
        if (!is_dir($diretorio_destino)) {
            mkdir($diretorio_destino, 0777, true);
        }

        if (move_uploaded_file($arquivo['tmp_name'], $diretorio_destino . $novo_nome)) {
            $imagem_final = "uploads/" . $novo_nome;
        }
    }

    if ($id) {
        // Atualiza produto existente
        $stmt = $db->prepare("UPDATE produtos SET nome=?, descricao=?, preco=?, estoque_atual=?, imagem_principal_url=? WHERE id=?");
        $stmt->execute([$nome, $descricao, $preco, $estoque, $imagem_final, $id]);
        $msg = "Produto atualizado com sucesso!";
    } else {
        // Cria novo produto
        $stmt = $db->prepare("INSERT INTO produtos (nome, descricao, preco, estoque_atual, imagem_principal_url) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$nome, $descricao, $preco, $estoque, $imagem_final]);
        $msg = "Produto adicionado à loja!";
    }
}

// Busca os dados do produto se o admin clicou em "Editar"
$produto_edit = null;
if (isset($_GET['editar'])) {
    $stmt = $db->prepare("SELECT * FROM produtos WHERE id = ?");
    $stmt->execute([$_GET['editar']]);
    $produto_edit = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Lista todos os produtos
$produtos = $db->query("SELECT * FROM produtos ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Gerenciar Produtos - Amor em Linhas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
    <script>
        const temaSalvo = localStorage.getItem('tema') || 'light';
        document.documentElement.setAttribute('data-bs-theme', temaSalvo);
    </script>
</head>

<body class="bg-light">

    <nav class="navbar navbar-expand-lg sticky-top shadow-sm"
        style="background-color: var(--primary-olive) !important;">
        <div class="container">
            <a class="navbar-brand fw-bold text-uppercase" href="dashboard.php"
                style="color: var(--dark-olive) !important; letter-spacing: 1px;">
                ⚙️ Painel Admin
            </a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item"><a class="nav-link" href="dashboard.php"
                            style="color: var(--dark-olive) !important;">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link fw-bold" href="gerenciar_produtos.php"
                            style="color: var(--dark-olive) !important;">Gerenciar Produtos</a></li>
                    <li class="nav-item">
                        <a href="gerenciar_banners.php" class="nav-link"
                            style="color: var(--dark-olive) !important;">Gerenciar Banners</a>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="config_pix.php"
                            style="color: var(--dark-olive) !important;">Configurar PIX</a></li>
                    <li class="nav-item d-none d-lg-block">
                            <span class="nav-link opacity-50" style="color: var(--dark-olive) !important;">|</span>
                    </li>
                    <li class="nav-item ms-lg-2">
                        <a class="nav-link" href="../index.php" target="_blank" style="color: var(--dark-olive) !important;">Ver Loja</a>
                    </li>
                    <li class="nav-item ms-lg-3"><a class="btn btn-danger btn-sm rounded-pill px-3 fw-bold text-white"
                            href="../logout.php">Sair</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5 mb-5">
        <?php if (isset($msg))
            echo "<div class='alert alert-success alert-dismissible fade show'>$msg <button type='button' class='btn-close' data-bs-dismiss='alert'></button></div>"; ?>
        <?php if (isset($_GET['msg']) && $_GET['msg'] == 'excluido')
            echo "<div class='alert alert-warning alert-dismissible fade show'>Produto excluído com sucesso!</div>"; ?>

        <div class="card shadow-sm border-0 p-4 mb-5" style="border-radius: 15px;">
            <h4 class="fw-bold mb-4" style="color: var(--dark-olive);">
                <?php echo $produto_edit ? '✏️ Editar Produto' : '📦 Adicionar Novo Produto'; ?>
            </h4>

            <form method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo $produto_edit['id'] ?? ''; ?>">
                <input type="hidden" name="imagem_atual"
                    value="<?php echo $produto_edit['imagem_principal_url'] ?? 'img/padrao.jpg'; ?>">

                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="fw-bold text-muted mb-1">Nome do Produto</label>
                        <input type="text" name="nome" class="form-control" required
                            value="<?php echo $produto_edit['nome'] ?? ''; ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="fw-bold text-muted mb-1">Upload da Imagem (Pasta Uploads)</label>
                        <input type="file" name="imagem_arquivo" class="form-control" accept="image/*">
                    </div>
                    <div class="col-md-3">
                        <label class="fw-bold text-muted mb-1">Preço (R$)</label>
                        <input type="number" step="0.01" name="preco" class="form-control" required
                            value="<?php echo $produto_edit['preco'] ?? ''; ?>">
                    </div>
                    <div class="col-md-3">
                        <label class="fw-bold text-muted mb-1">Estoque</label>
                        <input type="number" name="estoque_atual" class="form-control" required
                            value="<?php echo $produto_edit['estoque_atual'] ?? ''; ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="fw-bold text-muted mb-1">Descrição</label>
                        <textarea name="descricao" class="form-control" rows="1"
                            required><?php echo $produto_edit['descricao'] ?? ''; ?></textarea>
                    </div>
                </div>

                <div class="mt-4 pt-2 border-top">
                    <button type="submit" class="btn px-4 py-2 fw-bold"
                        style="background-color: var(--primary-olive); color: var(--dark-olive); border-radius: 50px;">
                        Salvar Produto
                    </button>
                    <?php if ($produto_edit): ?>
                        <a href="gerenciar_produtos.php" class="btn btn-outline-secondary px-4 py-2"
                            style="border-radius: 50px;">Cancelar</a>
                    <?php endif; ?>
                </div>
            </form>
        </div>

        <h4 class="fw-bold mb-3" style="color: var(--dark-olive);">Lista de Produtos</h4>
        <div class="card shadow-sm border-0 p-3" style="border-radius: 15px;">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="80">Img</th>
                            <th>Nome</th>
                            <th>Preço</th>
                            <th>Estoque</th>
                            <th width="150" class="text-center">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($produtos as $p): ?>
                            <tr>
                                <td><img src="../<?php echo $p['imagem_principal_url']; ?>" width="50" height="50"
                                        style="object-fit:cover; border-radius: 8px;"
                                        onerror="this.src='https://placehold.co/50x50/d4d9a1/434a11?text=Erro'"></td>
                                <td class="fw-bold"><?php echo $p['nome']; ?></td>
                                <td class="text-success fw-bold">R$ <?php echo number_format($p['preco'], 2, ',', '.'); ?>
                                </td>
                                <td><span class="badge bg-secondary"><?php echo $p['estoque_atual']; ?> un.</span></td>
                                <td class="text-center">
                                    <a href="?editar=<?php echo $p['id']; ?>"
                                        class="btn btn-sm btn-outline-primary">Editar</a>
                                    <a href="?excluir=<?php echo $p['id']; ?>" class="btn btn-sm btn-outline-danger"
                                        onclick="return confirm('Excluir?')">Excluir</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>