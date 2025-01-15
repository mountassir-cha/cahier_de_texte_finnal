@extends('layouts.auth')

@section('content')
<div class="auth-container">
    <div class="auth-card">
        <h2>Réinitialisation du mot de passe</h2>
        
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus>
                @error('email')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="btn-primary">
                Envoyer le lien de réinitialisation
            </button>
        </form>

        <div class="auth-links">
            <a href="{{ route('login') }}">Retour à la connexion</a>
        </div>
    </div>
</div>
@endsection 