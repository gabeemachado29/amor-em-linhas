// ============================================
// AMOR EM LINHAS — Cart System
// ============================================

function getCarrinho() {
    try {
        return JSON.parse(localStorage.getItem("carrinho")) || {};
    } catch (e) {
        return {};
    }
}

function salvarCarrinho(carrinho) {
    localStorage.setItem("carrinho", JSON.stringify(carrinho));
    atualizarBadgeCarrinho();
}

function addCarrinho(id) {
    let carrinho = getCarrinho();
    carrinho[id] = (carrinho[id] || 0) + 1;
    salvarCarrinho(carrinho);
    mostrarModalConfirmacao();
}

function mostrarModalConfirmacao() {
    // Remove modal anterior se existir (previne memory leak)
    const existente = document.getElementById('modalCarrinho');
    if (existente) {
        existente.remove();
    }

    const modalHTML = `
    <div class="modal fade" id="modalCarrinho" tabindex="-1">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-4 text-center" style="border-radius: 16px;">
          <div style="font-size: 2.5rem; margin-bottom: 12px;">🛒</div>
          <h5 style="font-weight: 600; color: var(--text-primary); margin-bottom: 4px;">Produto adicionado!</h5>
          <p style="color: var(--text-secondary); font-size: 0.9rem; margin-bottom: 20px;">O item foi adicionado à sua sacola.</p>
          <button class="btn btn-outline-secondary rounded-pill px-4 py-2 mb-2" data-bs-dismiss="modal" style="font-size: 0.9rem;">Continuar comprando</button>
          <a href="/carrinho" class="btn-comprar d-block rounded-pill py-2" style="text-decoration: none; text-align: center; font-size: 0.9rem;">Ver sacola</a>
        </div>
      </div>
    </div>`;

    document.body.insertAdjacentHTML('beforeend', modalHTML);

    const modalEl = document.getElementById('modalCarrinho');
    const myModal = new bootstrap.Modal(modalEl);
    myModal.show();

    // Limpa do DOM quando fechado (previne memory leak)
    modalEl.addEventListener('hidden.bs.modal', function () {
        modalEl.remove();
    });
}

function removerItem(id) {
    let carrinho = getCarrinho();
    delete carrinho[id];
    salvarCarrinho(carrinho);
    location.reload();
}

function limparCarrinho() {
    localStorage.removeItem("carrinho");
    atualizarBadgeCarrinho();
}

// Badge do carrinho na navbar
function atualizarBadgeCarrinho() {
    const badge = document.getElementById('cartBadge');
    if (!badge) return;

    const carrinho = getCarrinho();
    let totalItens = 0;
    for (let id in carrinho) {
        totalItens += carrinho[id];
    }

    if (totalItens > 0) {
        badge.textContent = totalItens > 99 ? '99+' : totalItens;
        badge.style.display = 'flex';
    } else {
        badge.textContent = '';
        badge.style.display = 'none';
    }
}
