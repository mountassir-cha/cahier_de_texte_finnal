@extends('layouts.dashboard')

@section('title', 'Paramètres')

@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <div class="header-wrapper">
            <div class="header-content">
                <h1>Paramètres</h1>
                <p class="text-subtitle">Gérez vos paramètres de compte</p>
            </div>
            <div class="header-actions">
                <div class="user-info">
                    <div class="user-avatar">
                        <img src="https://ui-avatars.com/api/?name={{ auth()->user()->name }}&background=6366F1&color=fff" alt="Profile">
                    </div>
                    <div class="user-details">
                        <span class="user-name">{{ auth()->user()->name }}</span>
                        <span class="user-email">{{ auth()->user()->email }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="settings-grid">
        <!-- Profil -->
        <div class="settings-card">
            <div class="card-header">
                <h2>Profil</h2>
                <p>Modifiez vos informations personnelles</p>
            </div>
            <form action="{{ route('settings.profile') }}" method="POST" class="settings-form">
                @csrf
                @method('PUT')
                
                <div class="form-group">
                    <label for="name">Nom complet</label>
                    <input type="text" 
                           id="name" 
                           name="name" 
                           value="{{ auth()->user()->name }}" 
                           class="form-control @error('name') is-invalid @enderror">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" 
                           id="email" 
                           name="email" 
                           value="{{ auth()->user()->email }}" 
                           class="form-control @error('email') is-invalid @enderror">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn-submit">
                    Mettre à jour le profil
                </button>
            </form>
        </div>

        <!-- Sécurité -->
        <div class="settings-card">
            <div class="card-header">
                <h2>Sécurité</h2>
                <p>Modifiez votre mot de passe</p>
            </div>
            <form action="{{ route('settings.password') }}" method="POST" class="settings-form">
                @csrf
                @method('PUT')
                
                <div class="form-group">
                    <label for="current_password">Mot de passe actuel</label>
                    <input type="password" 
                           id="current_password" 
                           name="current_password" 
                           class="form-control @error('current_password') is-invalid @enderror">
                    @error('current_password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">Nouveau mot de passe</label>
                    <input type="password" 
                           id="password" 
                           name="password" 
                           class="form-control @error('password') is-invalid @enderror">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Confirmer le mot de passe</label>
                    <input type="password" 
                           id="password_confirmation" 
                           name="password_confirmation" 
                           class="form-control">
                </div>

                <button type="submit" class="btn-submit">
                    Mettre à jour le mot de passe
                </button>
            </form>
        </div>
    </div>
</div>

@push('styles')
<style>
.header-wrapper {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
    padding-bottom: 1.5rem;
    border-bottom: 1px solid var(--gray-200);
}

.header-content h1 {
    font-size: 2rem;
    font-weight: 700;
    color: var(--gray-900);
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.header-content h1::before {
    content: '';
    display: block;
    width: 4px;
    height: 24px;
    background: var(--primary);
    border-radius: 2px;
}

.text-subtitle {
    color: var(--gray-500);
    font-size: 1rem;
    margin-left: 1.25rem;
}

.header-actions {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.user-info {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 0.75rem 1.5rem;
    background: white;
    border-radius: 1rem;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
}

.user-avatar {
    width: 2.5rem;
    height: 2.5rem;
    border-radius: 50%;
    overflow: hidden;
}

.user-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.user-details {
    display: flex;
    flex-direction: column;
}

.user-name {
    font-weight: 600;
    color: var(--gray-900);
    font-size: 0.875rem;
}

.user-email {
    color: var(--gray-500);
    font-size: 0.75rem;
}

@media (max-width: 768px) {
    .header-wrapper {
        flex-direction: column;
        gap: 1rem;
        align-items: flex-start;
    }

    .header-content h1 {
        font-size: 1.5rem;
    }

    .user-info {
        width: 100%;
        justify-content: flex-start;
    }
}

.settings-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
    gap: 2rem;
    margin-top: 2rem;
}

.settings-card {
    background: white;
    border-radius: 1rem;
    padding: 2rem;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
}

.card-header {
    margin-bottom: 2rem;
}

.card-header h2 {
    font-size: 1.25rem;
    color: var(--gray-900);
    margin-bottom: 0.5rem;
}

.card-header p {
    color: var(--gray-500);
    font-size: 0.875rem;
}

.settings-form {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.form-group label {
    font-size: 0.875rem;
    font-weight: 500;
    color: var(--gray-700);
}

.form-control {
    padding: 0.75rem 1rem;
    border: 1px solid var(--gray-300);
    border-radius: 0.5rem;
    font-size: 0.875rem;
    transition: all 0.2s;
}

.form-control:focus {
    outline: none;
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.1);
}

.form-control.is-invalid {
    border-color: var(--danger);
}

.invalid-feedback {
    color: var(--danger);
    font-size: 0.75rem;
    margin-top: 0.25rem;
}

.btn-submit {
    background: var(--primary);
    color: white;
    border: none;
    padding: 0.75rem 1.5rem;
    border-radius: 0.5rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s;
}

.btn-submit:hover {
    background: var(--primary-dark);
}

.alert {
    padding: 1rem;
    border-radius: 0.5rem;
    margin-bottom: 1rem;
}

.alert-success {
    background: #f0fdf4;
    border: 1px solid #bbf7d0;
    color: #166534;
}

@media (max-width: 768px) {
    .settings-grid {
        grid-template-columns: 1fr;
    }

    .settings-card {
        padding: 1.5rem;
    }
}
</style>
@endpush
@endsection 