<x-guest-layout>
    <div class="auth-card">
        <a href="{{ url('/') }}" class="auth-logo">♡ Amor em Linhas</a>
        <p class="auth-subtitle">Informe seu e-mail para receber o link de recuperação de senha.</p>

        @if (session('status'))
            <div class="alert alert-success mb-4" style="font-size: 0.88rem;">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="auth-form-group">
                <label for="email">E-mail</label>
                <div class="auth-input-icon">
                    <span class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                    </span>
                    <input id="email" class="auth-input" type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="seu@email.com">
                </div>
                @error('email')
                    <p class="auth-error">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="auth-btn">
                Enviar link de recuperação
            </button>
        </form>

        <div class="text-center mt-4">
            <a href="{{ route('login') }}" class="auth-link">← Voltar para o login</a>
        </div>
    </div>
</x-guest-layout>
