<?php
session_start();
include "includes/navbar.php";

if(isset($_GET['add'])){
    $_SESSION['carrinho'][] = [
        "nome" => $_GET['nome'],
        "preco" => $_GET['preco']
    ];
}

$carrinho = $_SESSION['carrinho'] ?? [];
$total = 0;
?>

<div class="container mt-5">
<h2>Seu Carrinho</h2>

<?php if(empty($carrinho)): ?>
<div class="alert alert-info">Carrinho vazio</div>
<?php else: ?>

<table class="table">
<tr><th>Produto</th><th>Preço</th></tr>
<?php foreach($carrinho as $item):
$total += $item['preco']; ?>
<tr>
<td><?php echo $item['nome']; ?></td>
<td>R$ <?php echo number_format($item['preco'],2,",","."); ?></td>
</tr>
<?php endforeach; ?>
</table>

<h4>Total: R$ <?php echo number_format($total,2,",","."); ?></h4>
<a href="checkout.php" class="btn btn-success">Finalizar Compra</a>

<?php endif; ?>
</div>

<?php include "scripts.php"; ?>
