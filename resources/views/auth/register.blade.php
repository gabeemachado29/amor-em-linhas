<x-guest-layout>
    <div class="auth-card">
        <!-- Logo -->
        <a href="{{ url('/') }}" class="auth-logo">♡ Amor em Linhas</a>
        <p class="auth-subtitle">Crie sua conta e comece a comprar.</p>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Nome -->
            <div class="auth-form-group">
                <label for="name">Nome completo</label>
                <div class="auth-input-icon">
                    <span class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    </span>
                    <input id="name" class="auth-input" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="Seu nome">
                </div>
                @error('name')
                    <p class="auth-error">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div class="auth-form-group">
                <label for="email">E-mail</label>
                <div class="auth-input-icon">
                    <span class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                    </span>
                    <input id="email" class="auth-input" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" placeholder="seu@email.com">
                </div>
                @error('email')
                    <p class="auth-error">{{ $message }}</p>
                @enderror
            </div>

            <!-- Telefone e CPF -->
            <div class="auth-row">
                <div class="auth-form-group">
                    <label for="telefone">Telefone</label>
                    <input id="telefone" class="auth-input" type="tel" name="telefone" value="{{ old('telefone') }}" autocomplete="tel" placeholder="(00) 00000-0000" maxlength="15">
                    @error('telefone')
                        <p class="auth-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="auth-form-group">
                    <label for="cpf">CPF</label>
                    <input id="cpf" class="auth-input" type="text" name="cpf" value="{{ old('cpf') }}" placeholder="000.000.000-00" maxlength="14">
                    @error('cpf')
                        <p class="auth-error">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Senha -->
            <div class="auth-form-group">
                <label for="password">Senha</label>
                <div class="auth-input-icon">
                    <span class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                    </span>
                    <input id="password" class="auth-input" type="password" name="password" required autocomplete="new-password" placeholder="Mínimo 8 caracteres">
                </div>
                <small style="color: var(--text-secondary); font-size: 0.78rem;">Use letras maiúsculas, minúsculas e números.</small>
                @error('password')
                    <p class="auth-error">{{ $message }}</p>
                @enderror
            </div>

            <!-- Confirmar Senha -->
            <div class="auth-form-group">
                <label for="password_confirmation">Confirmar senha</label>
                <div class="auth-input-icon">
                    <span class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10"/><path d="m9 12 2 2 4-4"/></svg>
                    </span>
                    <input id="password_confirmation" class="auth-input" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Repita a senha">
                </div>
                @error('password_confirmation')
                    <p class="auth-error">{{ $message }}</p>
                @enderror
            </div>

            <!-- Botão Registrar -->
            <button type="submit" class="auth-btn">
                Criar minha conta
            </button>
        </form>

        <div class="auth-divider">ou</div>

        <!-- Link Login -->
        <div class="text-center">
            <span style="color: var(--text-secondary); font-size: 0.9rem;">Já tem uma conta?</span>
            <a href="{{ route('login') }}" class="auth-link" style="margin-left: 4px;">
                Entrar
            </a>
        </div>
    </div>

    <script>
        // Máscara de telefone
        document.getElementById('telefone')?.addEventListener('input', function(e) {
            let v = e.target.value.replace(/\D/g, '');
            if (v.length > 11) v = v.slice(0, 11);
            if (v.length > 6) {
                v = '(' + v.slice(0,2) + ') ' + v.slice(2,7) + '-' + v.slice(7);
            } else if (v.length > 2) {
                v = '(' + v.slice(0,2) + ') ' + v.slice(2);
            } else if (v.length > 0) {
                v = '(' + v;
            }
            e.target.value = v;
        });

        // Máscara de CPF
        document.getElementById('cpf')?.addEventListener('input', function(e) {
            let v = e.target.value.replace(/\D/g, '');
            if (v.length > 11) v = v.slice(0, 11);
            if (v.length > 9) {
                v = v.slice(0,3) + '.' + v.slice(3,6) + '.' + v.slice(6,9) + '-' + v.slice(9);
            } else if (v.length > 6) {
                v = v.slice(0,3) + '.' + v.slice(3,6) + '.' + v.slice(6);
            } else if (v.length > 3) {
                v = v.slice(0,3) + '.' + v.slice(3);
            }
            e.target.value = v;
        });
    </script>
</x-guest-layout>
