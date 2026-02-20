<?php
session_start();
require "../config/database.php";

if(!isset($_SESSION['user']) || $_SESSION['user']['tipo_perfil'] != 'ADMIN'){
    die("Acesso negado");
}

/* MÉTRICAS */
$totalPedidos = $db->query("SELECT COUNT(*) FROM pedidos")->fetchColumn();
$faturamento = $db->query("SELECT SUM(valor_total) FROM pedidos WHERE status='PAGO'")->fetchColumn();
$aguardando = $db->query("SELECT COUNT(*) FROM pedidos WHERE status='AGUARDANDO_PAGAMENTO'")->fetchColumn();

/* VENDAS POR PRODUTO */
$vendas = $db->query("
SELECT produtos.nome, SUM(itens_pedido.quantidade) as total
FROM itens_pedido
JOIN produtos ON produtos.id = itens_pedido.produto_id
GROUP BY produto_id
")->fetchAll(PDO::FETCH_ASSOC);

$nomes = [];
$quantidades = [];

foreach($vendas as $v){
$nomes[] = $v['nome'];
$quantidades[] = $v['total'];
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Dashboard Admin</title>
<link rel="stylesheet" href="../assets/css/style.css">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

<header>
<div class="logo">Painel Administrativo</div>
<div>
<a href="../index.php">Ver Loja</a>
<a href="config_pix.php">Configurar PIX</a>
</div>
</header>

<div class="container">

<h2>📊 Dashboard</h2>

<div class="dashboard-grid">

<div class="metric">
<h3>Total de Pedidos</h3>
<p><?= $totalPedidos ?></p>
</div>

<div class="metric">
<h3>Pedidos Aguardando</h3>
<p><?= $aguardando ?></p>
</div>

<div class="metric">
<h3>Faturamento (Pago)</h3>
<p>R$ <?= number_format($faturamento ?? 0,2,",",".") ?></p>
</div>

</div>

<div class="card">
<h3>🔥 Produtos Mais Vendidos</h3>
<canvas id="graficoVendas"></canvas>
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
borderWidth: 1
}]
},
options: {
responsive:true,
plugins:{
legend:{display:false}
}
}
});
</script>

</body>
</html>
