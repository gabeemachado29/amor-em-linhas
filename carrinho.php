<?php include "includes/navbar.php"; ?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Carrinho</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
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

<div class="container mt-5">
    <h2>🛒 Seu Carrinho</h2>
    <hr>

    <div class="alert alert-info">
        Seu carrinho está vazio.
    </div>

    <a href="index.php" class="btn btn-secondary">Continuar Comprando</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
