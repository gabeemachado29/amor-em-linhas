<?php
require "config/database.php";

/* BUSCA PRODUTOS */
$produtos = $db->query("SELECT * FROM produtos")->fetchAll(PDO::FETCH_ASSOC);

/* ===== API JSON ===== */
if(isset($_GET['api']) && $_GET['api'] == 'produtos'){
    header('Content-Type: application/json');
    echo json_encode($produtos);
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Amor em Linhas</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<header>
    <div class="logo">🧶 Amor em Linhas</div>
    <div>
        <a href="index.php">Início</a> |
        <a href="carrinho.php">🛒 Carrinho</a> |
        <?php if(isset($_SESSION['user'])): ?>
            <a href="historico.php">Meus Pedidos</a> |
            <a href="logout.php">Sair</a>
        <?php else: ?>
            <a href="login.php">Login</a>
        <?php endif; ?>
    </div>
</header>

<div class="container">

<h2>✨ Nossos Produtos</h2>

<div class="grid">

<?php foreach($produtos as $p): ?>

<div class="card">

<?php if($p['destaque']): ?>
<div style="background:#ff4d88;color:white;padding:5px;border-radius:6px;margin-bottom:10px;">
⭐ DESTAQUE
</div>
<?php endif; ?>

<img src="<?= $p['imagem_principal_url'] ?>" width="100%" style="border-radius:10px;">

<h3><?= htmlspecialchars($p['nome']) ?></h3>

<p><?= htmlspecialchars($p['descricao']) ?></p>

<p><strong>R$ <?= number_format($p['preco'],2,",",".") ?></strong></p>

<?php if($p['estoque_atual'] > 0): ?>
<button class="btn" onclick="addCarrinho(<?= $p['id'] ?>)">
Adicionar ao Carrinho
</button>
<?php else: ?>
<button class="btn" disabled>
Esgotado
</button>
<?php endif; ?>

<p style="font-size:12px;color:#777;">
Estoque: <?= $p['estoque_atual'] ?>
</p>

</div>

<?php endforeach; ?>

</div>

</div>

<script src="js/carrinho.js"></script>

</body>
</html>
