<?php include "includes/navbar.php"; ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Amor em Linhas</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
<h2>Produtos</h2>

<div class="row">

<div class="col-md-4 mb-4">
<div class="card shadow-sm">
<img src="https://via.placeholder.com/300x250" class="card-img-top">
<div class="card-body">
<h5>Vestido Floral</h5>
<p>R$ 129,90</p>
<a href="carrinho.php?add=1&nome=Vestido Floral&preco=129.90"
class="btn btn-primary w-100">Adicionar</a>
</div>
</div>
</div>

</div>
</div>

<?php include "scripts.php"; ?>
</body>
</html>
