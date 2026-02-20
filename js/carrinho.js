function addCarrinho(id){
    let carrinho = JSON.parse(localStorage.getItem("carrinho")) || [];
    carrinho.push(id);
    localStorage.setItem("carrinho", JSON.stringify(carrinho));
    alert("Produto adicionado!");
}
