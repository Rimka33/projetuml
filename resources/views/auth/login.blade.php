<x-guest-layout>
    <h2 class="auth-heading text-center mb-4">Connexion</h2>

    @if (session('status'))
        <div class="alert alert-success mb-3">
            {{ session('status') }}
        </div>
    @endif

    <div class="auth-form-container text-start mx-auto">
        <form method="POST" action="{{ route('login') }}" class="auth-form">
            @csrf

            <div class="email mb-3">
                <label class="sr-only" for="email">Email</label>
                <input id="email" name="email" type="email" class="form-control @error('email') is-invalid @enderror"
                    placeholder="Email" required autofocus value="{{ old('email') }}">
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="password mb-3">
                <label class="sr-only" for="password">Mot de passe</label>
                <input id="password" name="password" type="password"
                    class="form-control @error('password') is-invalid @enderror"
                    placeholder="Mot de passe" required>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="extra mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember_me">
                    <label class="form-check-label" for="remember_me">
                        Se souvenir de moi
                    </label>
                </div>
            </div>

            <div class="text-center">
                <button type="submit" class="btn app-btn-primary w-100 theme-btn mx-auto">
                    Se connecter
                </button>
            </div>

            @if (Route::has('password.request'))
                <div class="auth-option text-center pt-3">
                    <a class="text-link" href="{{ route('password.request') }}">
                        Mot de passe oublié ?
                    </a>
                </div>
            @endif
        </form>
    </div>
</x-guest-layout>
