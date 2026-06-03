<x-guest-layout>
    <div class="auth-card">
        <a href="{{ url('/') }}" class="auth-logo">♡ Amor em Linhas</a>
        <p class="auth-subtitle">Por segurança, confirme sua senha antes de continuar.</p>

        <form method="POST" action="{{ route('password.confirm') }}">
            @csrf

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

            <button type="submit" class="auth-btn">
                Confirmar
            </button>
        </form>
    </div>
</x-guest-layout>
