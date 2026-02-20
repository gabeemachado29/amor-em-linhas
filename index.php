<?php
require "config/database.php";
$produtos = $db->query("SELECT * FROM produtos")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
<title>Amor em Linhas</title>
<link rel="stylesheet" href="css/style.css">
</head>
<body>

<h1>🧶 Amor em Linhas</h1>
<a href="carrinho.php">🛒 Carrinho</a>

<div class="grid">
<?php foreach($produtos as $p): ?>
<div class="card">
<img src="<?= $p['imagem_principal_url'] ?>" width="150">
<h3><?= $p['nome'] ?></h3>
<p>R$ <?= number_format($p['preco'],2,",",".") ?></p>

<?php if($p['estoque_atual'] > 0): ?>
<button onclick="addCarrinho(<?= $p['id'] ?>)">Comprar</button>
<?php else: ?>
<button disabled>Esgotado</button>
<?php endif; ?>

</div>
<?php endforeach; ?>
</div>

<script src="js/carrinho.js"></script>
</body>
</html>
