<?php
require_once "config/database.php";

$stmt = $db->query("SELECT * FROM produtos LIMIT 8");
$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Amor em Linhas</title>

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow">
  <div class="container">
    <a class="navbar-brand fw-bold" href="#">🧵 Amor em Linhas</a>
    <div>
      <a href="index.php" class="btn btn-outline-light me-2">Início</a>
      <a href="login.php" class="btn btn-outline-light">Login</a>
    </div>
  </div>
</nav>

<!-- BANNER -->
<div class="bg-light py-5 text-center">
    <h1 class="fw-bold">Nossos Produtos</h1>
    <p class="text-muted">Qualidade e carinho em cada detalhe</p>
</div>

<!-- PRODUTOS -->
<div class="container my-5">
    <div class="row g-4">

        <?php foreach($produtos as $produto): ?>
            <div class="col-md-4 col-lg-3">
                <div class="card h-100 shadow-sm border-0">
                    <img src="<?php echo $produto['imagem_principal_url']; ?>" 
                         class="card-img-top" 
                         style="height:250px; object-fit:cover;">

                    <div class="card-body text-center">
                        <h5 class="card-title"><?php echo $produto['nome']; ?></h5>
                        <p class="fw-bold text-primary">
                            R$ <?php echo number_format($produto['preco'],2,',','.'); ?>
                        </p>
                        <a href="produto.php?id=<?php echo $produto['id']; ?>" 
                           class="btn btn-primary w-100">
                           Ver Produto
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

    </div>
</div>

<!-- FOOTER -->
<footer class="bg-dark text-white text-center py-4">
    © <?php echo date('Y'); ?> Amor em Linhas - Todos os direitos reservados
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
