<?php
session_start();
require_once "config/database.php";

if(!isset($_SESSION['usuario'])){
    header("Location: login.php");
    exit;
}

$usuario_id = $_SESSION['usuario']['id'];

$stmt = $db->prepare("SELECT * FROM pedidos WHERE cliente_id = ?");
$stmt->execute([$usuario_id]);
$pedidos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Histórico</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<h2>Meus Pedidos</h2>

<?php foreach($pedidos as $pedido): ?>
    <div class="card-produto">
        <p><strong>Pedido:</strong> #<?php echo $pedido['id']; ?></p>
        <p>Status: <?php echo $pedido['status']; ?></p>
        <p>Total: R$ <?php echo number_format($pedido['valor_total'],2,',','.'); ?></p>
    </div>
<?php endforeach; ?>

</body>
</html>
