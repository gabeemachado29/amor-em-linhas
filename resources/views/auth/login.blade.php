<x-guest-layout>
    <div class="auth-card">
        <!-- Logo -->
        <a href="{{ url('/') }}" class="auth-logo">♡ Amor em Linhas</a>
        <p class="auth-subtitle">Bem-vinda de volta! Entre na sua conta.</p>

        <!-- Session Status -->
        @if (session('status'))
            <div class="alert alert-success mb-4" style="font-size: 0.88rem;">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email -->
            <div class="auth-form-group">
                <label for="email">E-mail</label>
                <div class="auth-input-icon">
                    <span class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                    </span>
                    <input id="email" class="auth-input" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="seu@email.com">
                </div>
                @error('email')
                    <p class="auth-error">{{ $message }}</p>
                @enderror
            </div>

            <!-- Senha -->
            <div class="auth-form-group">
                <label for="password">Senha</label>
                <div class="auth-input-icon">
                    <span class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                    </span>
                    <input id="password" class="auth-input" type="password" name="password" required autocomplete="current-password" placeholder="••••••••">
                </div>
                @error('password')
                    <p class="auth-error">{{ $message }}</p>
                @enderror
            </div>

            <!-- Lembrar + Esqueceu -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="auth-remember">
                    <input id="remember_me" type="checkbox" name="remember">
                    <label for="remember_me">Lembrar de mim</label>
                </div>
                @if (Route::has('password.request'))
                    <a class="auth-link" href="{{ route('password.request') }}">
                        Esqueceu a senha?
                    </a>
                @endif
            </div>

            <!-- Botão Login -->
            <button type="submit" class="auth-btn">
                Entrar
            </button>
        </form>

        <div class="auth-divider">ou</div>

        <!-- Link Registro -->
        <div class="text-center">
            <span style="color: var(--text-secondary); font-size: 0.9rem;">Ainda não tem conta?</span>
            <a href="{{ route('register') }}" class="auth-link" style="margin-left: 4px;">
                Criar conta grátis
            </a>
        </div>
    </div>
</x-guest-layout>
