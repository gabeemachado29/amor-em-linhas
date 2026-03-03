<?php
    session_start();
    require "../config/database.php";

    // Segurança: Apenas ADMIN
    if(!isset($_SESSION['user']) || $_SESSION['user']['tipo_perfil'] != 'ADMIN'){
        die("Acesso negado");
    }

    // AÇÃO: Alterar Status do Pedido (Aprovar ou Cancelar)
    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['acao_pedido'])){
        $pedido_id = $_POST['pedido_id'];
        $novo_status = $_POST['novo_status'];

        if($novo_status == 'CANCELADO'){
            // Devolve o estoque se for cancelado
            $stmt_itens_cancel = $db->prepare("SELECT produto_id, quantidade FROM itens_pedido WHERE pedido_id = ?");
            $stmt_itens_cancel->execute([$pedido_id]);
            $itens_cancelar = $stmt_itens_cancel->fetchAll(PDO::FETCH_ASSOC);

            foreach($itens_cancelar as $item){
                $stmt_estoque = $db->prepare("UPDATE produtos SET estoque_atual = estoque_atual + ? WHERE id = ?");
                $stmt_estoque->execute([$item['quantidade'], $item['produto_id']]);
            }
        }

        $stmt = $db->prepare("UPDATE pedidos SET status = ? WHERE id = ?");
        $stmt->execute([$novo_status, $pedido_id]);
        $msg_pedido = "Status do pedido #$pedido_id atualizado para $novo_status!";
    }

    /* MÉTRICAS */
    $totalPedidos = $db->query("SELECT COUNT(*) FROM pedidos")->fetchColumn();
    $faturamento = $db->query("SELECT SUM(valor_total) FROM pedidos WHERE status='PAGO'")->fetchColumn();
    $aguardando = $db->query("SELECT COUNT(*) FROM pedidos WHERE status='AGUARDANDO_PAGAMENTO'")->fetchColumn();

    /* VENDAS POR PRODUTO (Considerando apenas os PAGOS) */
    $vendas = $db->query("
    SELECT produtos.nome, SUM(itens_pedido.quantidade) as total
    FROM itens_pedido
    JOIN produtos ON produtos.id = itens_pedido.produto_id
    JOIN pedidos ON pedidos.id = itens_pedido.pedido_id
    WHERE pedidos.status = 'PAGO'
    GROUP BY produto_id
    ")->fetchAll(PDO::FETCH_ASSOC);

    $nomes = [];
    $quantidades = [];

    foreach($vendas as $v){
        $nomes[] = $v['nome'];
        $quantidades[] = $v['total'];
    }

    /* LISTA DOS ÚLTIMOS PEDIDOS */
    $pedidos_recentes = $db->query("
    SELECT p.id, p.data_criacao, p.status, p.valor_total, u.nome as cliente
    FROM pedidos p
    JOIN usuarios u ON p.cliente_id = u.id
    ORDER BY p.data_criacao DESC
    LIMIT 30
    ")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>Dashboard Admin - Amor em Linhas</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="../css/style.css">
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const temaSalvo = localStorage.getItem('tema') || 'light';
            document.documentElement.setAttribute('data-bs-theme', temaSalvo);
        </script>
    </head>
    <body class="bg-light">

        <nav class="navbar navbar-expand-lg sticky-top shadow-sm" style="background-color: var(--primary-olive) !important;">
            <div class="container">
                <a class="navbar-brand fw-bold text-uppercase" href="dashboard.php" style="color: var(--dark-olive) !important; letter-spacing: 1px;">
                    ⚙️ Painel Admin
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto align-items-center">
                        <li class="nav-item">
                            <a class="nav-link fw-bold" href="dashboard.php" style="color: var(--dark-olive) !important;">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="gerenciar_produtos.php" style="color: var(--dark-olive) !important;">Gerenciar Produtos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="config_pix.php" style="color: var(--dark-olive) !important;">Configurar PIX</a>
                        </li>
                        <li class="nav-item d-none d-lg-block">
                            <span class="nav-link opacity-50" style="color: var(--dark-olive) !important;">|</span>
                        </li>
                        <li class="nav-item ms-lg-2">
                            <a class="nav-link" href="../index.php" target="_blank" style="color: var(--dark-olive) !important;">Ver Loja</a>
                        </li>
                        <li class="nav-item ms-lg-3">
                            <a class="btn btn-danger btn-sm rounded-pill px-3 fw-bold text-white" href="../logout.php">Sair</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container mt-5 mb-5">

            <?php if(isset($msg_pedido)): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?php echo $msg_pedido; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <h3 class="fw-bold mb-4" style="color: var(--dark-olive);">Resumo da Loja</h3>

            <div class="row g-4 mb-5">
                <div class="col-md-4">
                    <div class="card shadow-sm border-0 h-100 p-4" style="border-radius: 15px;">
                        <h6 class="text-muted text-uppercase mb-2">Total de Pedidos</h6>
                        <h2 class="fw-bold mb-0" style="color: var(--dark-olive);"><?= $totalPedidos ?></h2>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card shadow-sm border-0 h-100 p-4 bg-warning bg-opacity-10" style="border-radius: 15px;">
                        <h6 class="text-warning text-uppercase fw-bold mb-2">Aguardando Pagamento</h6>
                        <h2 class="fw-bold mb-0 text-warning"><?= $aguardando ?></h2>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card shadow-sm border-0 h-100 p-4 bg-success bg-opacity-10" style="border-radius: 15px;">
                        <h6 class="text-success text-uppercase fw-bold mb-2">Faturamento (Recebido)</h6>
                        <h2 class="fw-bold mb-0 text-success">R$ <?= number_format($faturamento ?? 0, 2, ",", ".") ?></h2>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="card shadow-sm border-0 p-4" style="border-radius: 15px;">
                        <h5 class="fw-bold mb-4">📋 Últimos Pedidos</h5>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>#ID</th>
                                        <th>Cliente</th>
                                        <th>Valor</th>
                                        <th>Status</th>
                                        <th class="text-center">Ação</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($pedidos_recentes as $p): ?>
                                    <tr>
                                        <td class="fw-bold"><?= $p['id'] ?></td>
                                        <td><?= htmlspecialchars($p['cliente']) ?></td>
                                        <td class="fw-bold text-success">R$ <?= number_format($p['valor_total'], 2, ',', '.') ?></td>
                                        <td>
                                            <?php 
                                                $badge = 'bg-secondary';
                                                if($p['status'] == 'PAGO') $badge = 'bg-success';
                                                if($p['status'] == 'CANCELADO') $badge = 'bg-danger';
                                                if($p['status'] == 'AGUARDANDO_PAGAMENTO') $badge = 'bg-warning text-dark';
                                            ?>
                                            <span class="badge <?= $badge ?>"><?= str_replace('_', ' ', $p['status']) ?></span>
                                        </td>
                                        <td class="text-center">
                                            <?php if($p['status'] == 'AGUARDANDO_PAGAMENTO'): ?>
                                                <form method="POST" class="d-inline">
                                                    <input type="hidden" name="pedido_id" value="<?= $p['id'] ?>">
                                                    <input type="hidden" name="acao_pedido" value="1">
                                                    <button type="submit" name="novo_status" value="PAGO" class="btn btn-sm btn-success fw-bold" title="Aprovar Pagamento">✔️ Aprovar</button>
                                                    <button type="submit" name="novo_status" value="CANCELADO" class="btn btn-sm btn-outline-danger" onclick="return confirm('Tem certeza que deseja cancelar e devolver os itens ao estoque?')" title="Cancelar Pedido">❌</button>
                                                </form>
                                            <?php else: ?>
                                                <span class="text-muted small">Finalizado</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card shadow-sm border-0 p-4" style="border-radius: 15px;">
                        <h5 class="fw-bold mb-4">🔥 Mais Vendidos</h5>
                        <canvas id="graficoVendas"></canvas>
                    </div>
                </div>
            </div>

        </div>

        <script>
            const ctx = document.getElementById('graficoVendas');

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: <?= json_encode($nomes) ?>,
                    datasets: [{
                        label: 'Quantidade Vendida',
                        data: <?= json_encode($quantidades) ?>,
                        backgroundColor: '#d4d9a1', /* Cor primary-olive */
                        borderColor: '#434a11', /* Cor dark-olive */
                        borderWidth: 1,
                        borderRadius: 5
                    }]
                },
                options: {
                    responsive:true,
                    plugins:{
                        legend:{display:false}
                    },
                    scales: {
                        y: { beginAtZero: true }
                    }
                }
            });
        </script>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>