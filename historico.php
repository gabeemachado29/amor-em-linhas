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
<script>
document.addEventListener("DOMContentLoaded", function () {
    const temaSalvo = localStorage.getItem("tema");

    if (temaSalvo === "escuro") {
        document.body.classList.add("bg-dark", "text-light");
        document.querySelectorAll(".card").forEach(card => {
            card.classList.add("bg-secondary", "text-light");
        });
        document.querySelector(".navbar").classList.remove("navbar-dark","bg-dark");
        document.querySelector(".navbar").classList.add("navbar-dark","bg-black");
    }
});

function alternarTema() {
    const escuro = document.body.classList.toggle("bg-dark");

    if (escuro) {
        localStorage.setItem("tema","escuro");
        document.body.classList.add("text-light");
    } else {
        localStorage.setItem("tema","claro");
        document.body.classList.remove("text-light");
    }

    location.reload();
}
</script>
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
