<?php
require_once "config/database.php";

$id = $_GET['id'] ?? 0;

$stmt = $db->prepare("SELECT * FROM produtos WHERE id = ?");
$stmt->execute([$id]);
$produto = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$produto){
    die("Produto não encontrado");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo $produto['nome']; ?></title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="card-produto">
    <img src="<?php echo $produto['imagem_principal_url']; ?>" width="300">
    <h2><?php echo $produto['nome']; ?></h2>
    <p><?php echo $produto['descricao']; ?></p>
    <p class="preco">R$ <?php echo number_format($produto['preco'],2,',','.'); ?></p>
</div>

</body>
</html>
