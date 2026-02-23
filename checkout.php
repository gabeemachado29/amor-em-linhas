<?php
require "config/database.php";

if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit;
}

if($_POST){

$carrinho = json_decode($_POST['carrinho'], true);
$total = 0;

/* VALIDA E REDUZ ESTOQUE */
foreach($carrinho as $id => $qtd){

$produto = $db->query("SELECT * FROM produtos WHERE id = $id")->fetch(PDO::FETCH_ASSOC);

if($produto['estoque_atual'] < $qtd){
die("Estoque insuficiente para ".$produto['nome']);
}

$total += $produto['preco'] * $qtd;

$db->exec("UPDATE produtos SET estoque_atual = estoque_atual - $qtd WHERE id = $id");
}

/* CRIA PEDIDO */
$stmt = $db->prepare("INSERT INTO pedidos 
(cliente_id,data_criacao,status,tipo_entrega,valor_frete,valor_total)
VALUES (?,?,?,?,?,?)");

$stmt->execute([
$_SESSION['user']['id'],
date("Y-m-d H:i:s"),
"AGUARDANDO_PAGAMENTO",
"ENTREGA",
0,
$total
]);

$pedido_id = $db->lastInsertId();

/* SALVA ITENS */
foreach($carrinho as $id => $qtd){

$produto = $db->query("SELECT * FROM produtos WHERE id = $id")->fetch(PDO::FETCH_ASSOC);

$stmt = $db->prepare("INSERT INTO itens_pedido 
(pedido_id,produto_id,quantidade,preco_unitario)
VALUES (?,?,?,?)");

$stmt->execute([$pedido_id,$id,$qtd,$produto['preco']]);
}

/* PIX */
$config = $db->query("SELECT * FROM configuracao_loja LIMIT 1")->fetch(PDO::FETCH_ASSOC);

$pixPayload = "00020126580014BR.GOV.BCB.PIX0136".$config['chave_pix_destino']."5204000053039865405".$total."5802BR5925".$config['nome_beneficiario']."6009".$config['cidade_beneficiario']."6304";

$qrCode = "https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=".$pixPayload;

echo "<h2>Pedido criado!</h2>";
echo "<img src='$qrCode'>";
echo "<p>Chave PIX: ".$config['chave_pix_destino']."</p>";
echo "<script>localStorage.removeItem('carrinho');</script>";

exit;
}
?>

<form method="POST" onsubmit="enviarCarrinho()">
<input type="hidden" name="carrinho" id="carrinhoInput">
<button class="btn">Confirmar Pedido</button>
</form>

<script>
function enviarCarrinho(){
let carrinho = localStorage.getItem("carrinho");
document.getElementById("carrinhoInput").value = carrinho;
}
</script>
