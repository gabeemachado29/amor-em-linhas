<?php
require "config/database.php";

if(!isset($_SESSION['user'])){
header("Location: login.php");
exit;
}

$id = $_SESSION['user']['id'];

$pedidos = $db->query("SELECT * FROM pedidos WHERE cliente_id = $id ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<link rel="stylesheet" href="assets/css/style.css">
<div class="container">
<h2>📦 Meus Pedidos</h2>

<?php foreach($pedidos as $p): ?>
<div class="card">
Pedido #<?= $p['id'] ?><br>
Status: <?= $p['status'] ?><br>
Total: R$ <?= number_format($p['valor_total'],2,",",".") ?>
</div>
<?php endforeach; ?>

</div>
