function getCarrinho(){
    return JSON.parse(localStorage.getItem("carrinho")) || {};
}

function salvarCarrinho(carrinho){
    localStorage.setItem("carrinho", JSON.stringify(carrinho));
}

function addCarrinho(id){
    let carrinho = getCarrinho();
    carrinho[id] = (carrinho[id] || 0) + 1;
    salvarCarrinho(carrinho);
    
    // Em vez de alert, use um modal do Bootstrap para o estilo da imagem 150667.jpg
    mostrarModalConfirmacao();
}

function mostrarModalConfirmacao() {
    const modalHTML = `
    <div class="modal fade" id="modalCarrinho" tabindex="-1">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 p-4 text-center">
          <h5>Produto adicionado à sacola!</h5>
          <button class="btn btn-outline-secondary rounded-pill mt-3" data-bs-dismiss="modal">Continuar comprando</button>
          <a href="carrinho.php" class="btn btn-comprar rounded-pill mt-2">Finalizar compra</a>
        </div>
      </div>
    </div>`;
    
    document.body.insertAdjacentHTML('beforeend', modalHTML);
    var myModal = new bootstrap.Modal(document.getElementById('modalCarrinho'));
    myModal.show();
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
