<?php
require_once "config/database.php";

$stmt = $db->query("SELECT * FROM produtos LIMIT 8");
$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Amor em Linhas</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<header>
    <div class="logo">🧵 Amor em Linhas</div>
</header>

<h2 style="padding:20px;">Nossos Produtos</h2>

<div class="produtos-container">

<?php foreach($produtos as $produto): ?>

    <div class="card-produto">
        <img src="<?php echo $produto['imagem_principal_url']; ?>" height="200">
        <h3><?php echo $produto['nome']; ?></h3>
        <p class="preco">R$ <?php echo number_format($produto['preco'],2,',','.'); ?></p>
        <a href="produto.php?id=<?php echo $produto['id']; ?>">
            <button>Ver Produto</button>
        </a>
    </div>

<?php endforeach; ?>

</div>

</body>
</html>
