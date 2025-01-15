@extends('layouts.auth')

@section('content')
<div class="auth-container">
    <div class="auth-card">
        <h2>Connexion</h2>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus>
                @error('email')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" name="password" id="password" required>
                @error('password')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-check">
                <input type="checkbox" name="remember" id="remember">
                <label for="remember">Se souvenir de moi</label>
            </div>

            <button type="submit" class="btn-primary">
                Se connecter
            </button>
        </form>

        <div class="auth-links">
            <a href="{{ route('password.request') }}">Mot de passe oublié ?</a>
            <p>Pas encore de compte ? <a href="{{ route('register') }}">S'inscrire</a></p>
        </div>
    </div>
</div>
@endsection 