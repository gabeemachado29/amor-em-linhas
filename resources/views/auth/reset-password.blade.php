<x-guest-layout>
    <div class="auth-card">
        <a href="{{ url('/') }}" class="auth-logo">♡ Amor em Linhas</a>
        <p class="auth-subtitle">Defina sua nova senha abaixo.</p>

        <form method="POST" action="{{ route('password.store') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <div class="auth-form-group">
                <label for="email">E-mail</label>
                <input id="email" class="auth-input" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username">
                @error('email')
                    <p class="auth-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="auth-form-group">
                <label for="password">Nova senha</label>
                <input id="password" class="auth-input" type="password" name="password" required autocomplete="new-password" placeholder="Mínimo 8 caracteres">
                @error('password')
                    <p class="auth-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="auth-form-group">
                <label for="password_confirmation">Confirmar nova senha</label>
                <input id="password_confirmation" class="auth-input" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Repita a senha">
                @error('password_confirmation')
                    <p class="auth-error">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="auth-btn">
                Redefinir senha
            </button>
        </form>
    </div>
</x-guest-layout>
