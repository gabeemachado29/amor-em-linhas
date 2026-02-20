function getCarrinho(){
    return JSON.parse(localStorage.getItem("carrinho")) || {};
}

function salvarCarrinho(carrinho){
    localStorage.setItem("carrinho", JSON.stringify(carrinho));
}

function addCarrinho(id){
    let carrinho = getCarrinho();

    if(carrinho[id]){
        carrinho[id]++;
    }else{
        carrinho[id] = 1;
    }

    salvarCarrinho(carrinho);
    alert("Produto adicionado ao carrinho!");
}

function removerItem(id){
    let carrinho = getCarrinho();
    delete carrinho[id];
    salvarCarrinho(carrinho);
    location.reload();
}

function limparCarrinho(){
    localStorage.removeItem("carrinho");
}
