<?php
    require_once "config/database.php";

    $id = $_GET['id'] ?? 0;

    $stmt = $db->prepare("SELECT * FROM produtos WHERE id = ?");
    $stmt->execute([$id]);
    $produto = $stmt->fetch(PDO::FETCH_ASSOC);

    if(!$produto){
        die("Produto não encontrado");
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <link rel="stylesheet" href="css/style.css">
        <script>
            const temaSalvo = localStorage.getItem('tema') || 'light';
            document.documentElement.setAttribute('data-bs-theme', temaSalvo);
        </script>
        <meta charset="UTF-8">
        <title><?php echo htmlspecialchars($produto['nome']); ?></title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>

        <nav class="navbar navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="index.php">🧵 Amor em Linhas</a>
            </div>
        </nav>

        <div class="container my-5">
            <div class="row">
                <div class="col-md-6">
                    <img src="<?php echo htmlspecialchars($produto['imagem_principal_url']); ?>" 
                        class="img-fluid rounded shadow">
                </div>
                <div class="col-md-6">
                    <h2><?php echo htmlspecialchars($produto['nome']); ?></h2>
                    <p class="text-muted"><?php echo htmlspecialchars($produto['descricao']); ?></p>
                    <h3 class="text-primary">
                        R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?>
                    </h3>

                    <?php if ($produto['estoque_atual'] > 0): ?>
                        <button class="btn btn-success btn-lg mt-3 w-100" onclick="addCarrinho(<?php echo $produto['id']; ?>)">
                            Comprar Agora
                        </button>
                    <?php else: ?>
                        <button class="btn btn-secondary btn-lg mt-3 w-100" disabled>
                            Esgotado
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <script src="js/carrinho.js"></script>
    </body>
</html>