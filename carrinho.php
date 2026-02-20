<?php require "config/database.php"; ?>

<!DOCTYPE html>
<html>
<head>
<title>Carrinho</title>
</head>
<body>

<h2>Seu Carrinho</h2>
<div id="lista"></div>

<a href="checkout.php">Finalizar Compra</a>

<script>
let carrinho = JSON.parse(localStorage.getItem("carrinho")) || [];
let html = "";

carrinho.forEach(id => {
    html += "Produto ID: " + id + "<br>";
});

document.getElementById("lista").innerHTML = html;
</script>

</body>
</html>
