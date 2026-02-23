<?php include "includes/navbar.php"; ?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Amor em Linhas</title>
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
    <h2 class="mb-4">Nossos Produtos</h2>

    <div class="row">

        <!-- PRODUTO 1 -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm">
                <img src="https://via.placeholder.com/300x250" class="card-img-top">
                <div class="card-body">
                    <h5 class="card-title">Vestido Floral</h5>
                    <p class="card-text">R$ 129,90</p>
                    <a href="#" class="btn btn-primary w-100">Adicionar ao Carrinho</a>
                </div>
            </div>
        </div>

        <!-- PRODUTO 2 -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm">
                <img src="https://via.placeholder.com/300x250" class="card-img-top">
                <div class="card-body">
                    <h5 class="card-title">Blusa Romântica</h5>
                    <p class="card-text">R$ 79,90</p>
                    <a href="#" class="btn btn-primary w-100">Adicionar ao Carrinho</a>
                </div>
            </div>
        </div>

        <!-- PRODUTO 3 -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm">
                <img src="https://via.placeholder.com/300x250" class="card-img-top">
                <div class="card-body">
                    <h5 class="card-title">Saia Midi</h5>
                    <p class="card-text">R$ 99,90</p>
                    <a href="#" class="btn btn-primary w-100">Adicionar ao Carrinho</a>
                </div>
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
