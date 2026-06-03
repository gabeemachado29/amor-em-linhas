<x-guest-layout>
    <div class="auth-card">
        <a href="{{ url('/') }}" class="auth-logo">♡ Amor em Linhas</a>
        <p class="auth-subtitle">
            Obrigado por se cadastrar! Antes de começar, verifique seu e-mail clicando no link que acabamos de enviar. Se não recebeu, podemos reenviar.
        </p>

        @if (session('status') == 'verification-link-sent')
            <div class="alert alert-success mb-4" style="font-size: 0.88rem;">
                Um novo link de verificação foi enviado para o e-mail cadastrado.
            </div>
        @endif

        <div class="d-flex justify-content-between align-items-center gap-3">
            <form method="POST" action="{{ route('verification.send') }}" class="flex-grow-1">
                @csrf
                <button type="submit" class="auth-btn">
                    Reenviar e-mail
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="auth-link" style="background: none; border: none; cursor: pointer;">
                    Sair
                </button>
            </form>
        </div>
    </div>
</x-guest-layout>
