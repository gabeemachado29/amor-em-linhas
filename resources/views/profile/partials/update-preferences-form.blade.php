<section id="preferencias">
    <header>
        <h4 class="fw-bold" style="color: var(--primary-color);">Preferências de Exibição</h4>
        <p class="text-muted mt-1 text-sm">
            Personalize a aparência do sistema de acordo com sua preferência.
        </p>
    </header>

    <div class="mt-4">
        <label for="seletorTema" class="form-label fw-medium">Tema da Interface</label>
        <select id="seletorTema" class="form-select w-100" style="max-width: 300px;" onchange="mudarTema()">
            <option value="light">☀️ Tema Claro</option>
            <option value="dark">🌙 Tema Escuro</option>
        </select>
        <small class="text-muted d-block mt-2">Esta configuração é salva automaticamente no seu dispositivo.</small>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Inicializar com o tema que está no localStorage
            const temaAtual = localStorage.getItem('tema') || 'light';
            document.getElementById('seletorTema').value = temaAtual;
        });

        function mudarTema() {
            const temaEscolhido = document.getElementById('seletorTema').value;
            document.documentElement.setAttribute('data-bs-theme', temaEscolhido);
            localStorage.setItem('tema', temaEscolhido);
        }
    </script>
</section>
