<?php
require "config/database.php";

if(!isset($_GET['id'])){
    header("Location: index.php");
    exit;
}

$id = intval($_GET['id']);

$stmt = $db->prepare("SELECT * FROM produtos WHERE id = ?");
$stmt->execute([$id]);
$produto = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$produto){
    echo "Produto não encontrado.";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title><?= htmlspecialchars($produto['nome']) ?></title>
<link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<header>
<div class="logo">🧶 Amor em Linhas</div>
<a href="index.php">← Voltar</a>
</header>

<div class="container">

<div style="display:flex; gap:40px; flex-wrap:wrap;">

<div style="flex:1; min-width:300px;">
<img src="<?= $produto['imagem_principal_url'] ?>" 
     style="width:100%; border-radius:12px;">
</div>

<div style="flex:1; min-width:300px;">

<h2><?= htmlspecialchars($produto['nome']) ?></h2>

<p><?= nl2br(htmlspecialchars($produto['descricao'])) ?></p>

<h3>R$ <?= number_format($produto['preco'],2,",",".") ?></h3>

<?php if($produto['estoque_atual'] > 0): ?>
<p style="color:green;">Disponível em estoque</p>

<button class="btn" onclick="addCarrinho(<?= $produto['id'] ?>)">
Adicionar ao Carrinho
</button>
<?php else: ?>
<p style="color:red;">Produto Esgotado</p>
<button class="btn" disabled>Esgotado</button>
<?php endif; ?>

<p style="margin-top:20px;font-size:14px;color:#777;">
Estoque atual: <?= $produto['estoque_atual'] ?>
</p>

</div>
</div>

</div>

<script src="js/carrinho.js"></script>
</body>
</html>
