<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "config/database.php";

// Verifica se o usuário está logado
if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit;
}

$usuario_id = $_SESSION['user']['id'];

// Busca todos os pedidos desse usuário específico
$stmt = $db->prepare("
    SELECT id, data_criacao, status, valor_total 
    FROM pedidos 
    WHERE cliente_id = ? 
    ORDER BY data_criacao DESC
");
$stmt->execute([$usuario_id]);
$pedidos = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    <title>Meu Histórico de Compras - Amor em Linhas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script>
        // Aplica o tema salvo antes de carregar a página
        const temaSalvo = localStorage.getItem('tema') || 'light';
        document.documentElement.setAttribute('data-bs-theme', temaSalvo);
    </script>
</head>
<body>

<?php include "includes/navbar.php"; ?>

<div class="container mt-5 mb-5">
    <div class="row">
        <div class="col-12">
            <h2 class="mb-4">🛍️ Meu Histórico de Compras</h2>
            
            <div class="card shadow-sm">
                <div class="card-body">
                    <?php if(count($pedidos) > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Pedido #</th>
                                        <th>Data da Compra</th>
                                        <th>Status</th>
                                        <th>Total</th>
                                        <th class="text-center">Ação</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($pedidos as $pedido): ?>
                                        <tr>
                                            <td class="fw-bold"><?php echo $pedido['id']; ?></td>
                                            <td><?php echo date('d/m/Y H:i', strtotime($pedido['data_criacao'])); ?></td>
                                            <td>
                                                <?php 
                                                    $badgeClass = 'bg-secondary';
                                                    if($pedido['status'] == 'PAGO') $badgeClass = 'bg-success';
                                                    if($pedido['status'] == 'CANCELADO') $badgeClass = 'bg-danger';
                                                    if($pedido['status'] == 'AGUARDANDO_PAGAMENTO') $badgeClass = 'bg-warning text-dark';
                                                ?>
                                                <span class="badge <?php echo $badgeClass; ?>">
                                                    <?php echo str_replace('_', ' ', $pedido['status']); ?>
                                                </span>
                                            </td>
                                            <td class="text-success fw-bold">
                                                R$ <?php echo number_format($pedido['valor_total'], 2, ',', '.'); ?>
                                            </td>
                                            <td class="text-center">
                                                <a href="detalhes_pedido.php?id=<?php echo $pedido['id']; ?>" class="btn btn-sm btn-outline-primary">Ver Detalhes</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <h5 class="text-muted">Você ainda não realizou nenhuma compra.</h5>
                            <p>Que tal dar uma olhada nos nossos produtos exclusivos?</p>
                            <a href="index.php" class="btn btn-primary">Ir para a Loja</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>