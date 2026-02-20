<?php require "config/database.php"; ?>

<link rel="stylesheet" href="assets/css/style.css">
<div class="container">
<h2>🛒 Seu Carrinho</h2>

<div id="lista"></div>
<h3 id="total"></h3>

<input type="text" id="cep" placeholder="Digite seu CEP">
<button onclick="calcularFrete()">Calcular Frete</button>
<p id="frete"></p>

<a href="checkout.php"><button class="btn">Finalizar Compra</button></a>
</div>

<script>
let carrinho = JSON.parse(localStorage.getItem("carrinho")) || {};
let html = "";
let total = 0;

fetch("index.php?api=produtos")
.then(res => res.json())
.then(produtos => {

for(let id in carrinho){

let p = produtos.find(x => x.id == id);

if(p){
let qtd = carrinho[id];
let subtotal = p.preco * qtd;
total += subtotal;

html += `
<div>
${p.nome} - Qtd: ${qtd} - R$ ${subtotal.toFixed(2)}
<button onclick="removerItem(${id})">Remover</button>
</div>
`;
}
}

document.getElementById("lista").innerHTML = html;
document.getElementById("total").innerHTML = "Total: R$ " + total.toFixed(2);

});

function calcularFrete(){
let cep = document.getElementById("cep").value;
cep = cep.replace("-", "");

let valor = 25;

if(cep.startsWith("0") || cep.startsWith("1")) valor = 15;
if(cep.startsWith("2") || cep.startsWith("3")) valor = 20;

document.getElementById("frete").innerHTML = "Frete: R$ " + valor.toFixed(2);
}
</script>

<script src="js/carrinho.js"></script>
