<?php
session_start();
$carrinho = $_SESSION['carrinho'] ?? [];
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Carrinho - Amor em Linhas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="index.php">🧵 Amor em Linhas</a>
    </div>
</nav>

<div class="container my-5">

    <h2 class="mb-4">🛒 Seu Carrinho</h2>

    <?php if(empty($carrinho)): ?>
        <div class="alert alert-info">
            Seu carrinho está vazio.
        </div>
    <?php else: ?>

        <table class="table table-bordered bg-white shadow-sm">
            <thead class="table-dark">
                <tr>
                    <th>Produto</th>
                    <th>Preço</th>
                    <th>Quantidade</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $total = 0;
                foreach($carrinho as $item): 
                    $subtotal = $item['preco'] * $item['quantidade'];
                    $total += $subtotal;
                ?>
                    <tr>
                        <td><?php echo $item['nome']; ?></td>
                        <td>R$ <?php echo number_format($item['preco'],2,',','.'); ?></td>
                        <td><?php echo $item['quantidade']; ?></td>
                        <td>R$ <?php echo number_format($subtotal,2,',','.'); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="text-end">
            <h4>Total: 
                <span class="text-primary">
                    R$ <?php echo number_format($total,2,',','.'); ?>
                </span>
            </h4>

            <a href="checkout.php" class="btn btn-success btn-lg mt-3">
                Finalizar Compra
            </a>
        </div>

    <?php endif; ?>

</div>

</body>
</html>
