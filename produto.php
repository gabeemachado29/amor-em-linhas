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
    <meta charset="UTF-8">
    <title><?php echo $produto['nome']; ?></title>
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
            <img src="<?php echo $produto['imagem_principal_url']; ?>" 
                 class="img-fluid rounded shadow">
        </div>
        <div class="col-md-6">
            <h2><?php echo $produto['nome']; ?></h2>
            <p class="text-muted"><?php echo $produto['descricao']; ?></p>
            <h3 class="text-primary">
                R$ <?php echo number_format($produto['preco'],2,',','.'); ?>
            </h3>

            <button class="btn btn-success btn-lg mt-3 w-100">
                Comprar Agora
            </button>
        </div>
    </div>
</div>

</body>
</html>
