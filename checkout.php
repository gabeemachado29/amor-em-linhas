<?php
session_start();
include "includes/navbar.php";

$total = 0;
foreach($_SESSION['carrinho'] ?? [] as $item){
    $total += $item['preco'];
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
    unset($_SESSION['carrinho']);
    $sucesso = true;
}
?>

<div class="container mt-5">
<h2>Finalizar Compra</h2>

<?php if(isset($sucesso)): ?>
<div class="alert alert-success">
Compra realizada com sucesso 🎉
</div>
<?php else: ?>

<h4>Total: R$ <?php echo number_format($total,2,",","."); ?></h4>
<form method="POST">
<button class="btn btn-success">Confirmar Pagamento</button>
</form>

<?php endif; ?>
</div>

<?php include "scripts.php"; ?>
