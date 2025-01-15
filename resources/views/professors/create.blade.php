@extends('layouts.dashboard')

@section('title', 'Ajouter un Professeur')

@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <div class="header-wrapper">
            <div class="header-content">
                <h1>Ajouter un Professeur</h1>
                <p class="text-subtitle">Créez un nouveau compte professeur</p>
            </div>
            <div class="header-actions">
                <a href="{{ route('professors.index') }}" class="btn-secondary">
                    <i class="fas fa-arrow-left"></i>
                    Retour à la liste
                </a>
            </div>
        </div>
    </div>

    <div class="content-card">
        <div class="card-body">
            <form action="{{ route('professors.store') }}" method="POST" class="create-form">
                @csrf
                
                <div class="form-group">
                    <label for="name">Nom complet</label>
                    <div class="input-wrapper">
                        <i class="fas fa-user icon"></i>
                        <input type="text" 
                               id="name" 
                               name="name" 
                               class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name') }}" 
                               required>
                    </div>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <div class="input-wrapper">
                        <i class="fas fa-envelope icon"></i>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email') }}" 
                               required>
                    </div>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">Mot de passe</label>
                    <div class="input-wrapper">
                        <i class="fas fa-lock icon"></i>
                        <input type="password" 
                               id="password" 
                               name="password" 
                               class="form-control @error('password') is-invalid @enderror"
                               required>
                    </div>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Confirmer le mot de passe</label>
                    <div class="input-wrapper">
                        <i class="fas fa-lock icon"></i>
                        <input type="password" 
                               id="password_confirmation" 
                               name="password_confirmation" 
                               class="form-control"
                               required>
                    </div>
                </div>

                <div class="form-group checkbox-group">
                    <label class="checkbox-container">
                        <input type="checkbox" 
                               name="is_active" 
                               id="is_active" 
                               value="1" 
                               {{ old('is_active', true) ? 'checked' : '' }}>
                        <span class="checkmark"></span>
                        Compte actif
                    </label>
                </div>

                <div class="form-actions">
                    <button type="reset" class="btn-secondary">
                        <i class="fas fa-undo"></i>
                        Réinitialiser
                    </button>
                    <button type="submit" class="btn-primary">
                        <i class="fas fa-save"></i>
                        Enregistrer
                    </button>
                </div>
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
}

.btn-back {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #6B7280;
    text-decoration: none;
    transition: color 0.2s;
}

.btn-back:hover {
    color: var(--primary);
}

.card {
    background: white;
    border-radius: 1rem;
    padding: 2rem;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    margin-bottom: 2rem;
    max-width: 800px;
}

.form-row {
    display: flex;
    margin-left: -1rem;
    margin-right: -1rem;
    gap: 1rem;
}

.form-group {
    margin-bottom: 1.5rem;
    padding: 0 1rem;
    flex: 1;
}

.col-md-6 {
    flex: 0 0 calc(50% - 2rem);
}

.form-group label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 500;
    color: #374151;
}

.input-icon {
    position: relative;
}

.input-icon i {
    position: absolute;
    left: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: #6B7280;
}

.form-control {
    width: 100%;
    padding: 0.75rem 1rem 0.75rem 2.5rem;
    border: 1px solid #D1D5DB;
    border-radius: 0.5rem;
    font-size: 0.95rem;
    transition: all 0.2s;
}

.form-control:focus {
    border-color: var(--primary);
    outline: none;
    box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.1);
}

select.form-control {
    appearance: none;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e");
    background-repeat: no-repeat;
    background-position: right 0.75rem center;
    background-size: 16px 12px;
    padding-right: 2.5rem;
}

.is-invalid {
    border-color: var(--danger) !important;
}

.invalid-feedback {
    color: var(--danger);
    font-size: 0.875rem;
    margin-top: 0.25rem;
}

.custom-control {
    margin-top: 1rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0 1rem;
}

.custom-control-input {
    width: 1.25rem;
    height: 1.25rem;
    border-radius: 0.25rem;
    border: 2px solid #D1D5DB;
    cursor: pointer;
}

.custom-control-input:checked {
    background-color: var(--primary);
    border-color: var(--primary);
}

.custom-control-label {
    cursor: pointer;
    user-select: none;
}

.form-actions {
    display: flex;
    gap: 1rem;
    margin-top: 2rem;
    padding: 1rem;
    border-top: 1px solid #E5E7EB;
}

.btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    border-radius: 0.5rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s;
    border: none;
}

.btn i {
    font-size: 1.1rem;
}

.btn-primary {
    background: var(--primary);
    color: white;
}

.btn-primary:hover {
    background: var(--primary-dark);
}

.btn-secondary {
    background: #F3F4F6;
    color: #374151;
    text-decoration: none;
}

.btn-secondary:hover {
    background: #E5E7EB;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .form-row {
        flex-direction: column;
    }

    .col-md-6 {
        flex: 0 0 100%;
    }

    .card {
        margin: 1rem;
        padding: 1.5rem;
    }

    .form-actions {
        flex-direction: column;
    }

    .btn {
        width: 100%;
        justify-content: center;
    }
}
</style>
@endpush
@endsection 