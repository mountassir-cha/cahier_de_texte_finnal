@extends('layouts.dashboard')

@section('title', 'Modifier le Professeur')

@section('content')
<div class="form-container">
    <div class="form-header">
        <div class="header-content">
            <h1>Modifier le Professeur</h1>
            <p class="text-subtitle">Modification des informations de {{ $professor->first_name }} {{ $professor->last_name }}</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('professors.index') }}" class="back-button">
                <i class="fas fa-arrow-left"></i>
                <span>Retour à la liste</span>
            </a>
            <a href="{{ route('professors.create') }}" class="btn-add">
                <i class="fas fa-plus"></i>
                <span>Nouveau Professeur</span>
            </a>
        </div>
    </div>

    <div class="card">
        <form action="{{ route('professors.update', ['id' => $professor->id]) }}" method="POST">
            @csrf
            @method('PUT')
            
            @if ($errors->any())
                <div class="alert alert-danger">
                    <div class="alert-title">
                        <i class="fas fa-exclamation-circle"></i>
                        <span>Erreur de validation</span>
                    </div>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="form-grid">
                <div class="form-group">
                    <label for="first_name">
                        <i class="fas fa-user"></i>
                        Prénom
                    </label>
                    <div class="input-group">
                        <input type="text" id="first_name" name="first_name" 
                               value="{{ old('first_name', $professor->first_name) }}" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="last_name">
                        <i class="fas fa-user"></i>
                        Nom
                    </label>
                    <div class="input-group">
                        <input type="text" id="last_name" name="last_name" 
                               value="{{ old('last_name', $professor->last_name) }}" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="email">
                        <i class="fas fa-envelope"></i>
                        Email
                    </label>
                    <div class="input-group">
                        <input type="email" id="email" name="email" 
                               value="{{ old('email', $professor->email) }}" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="phone">
                        <i class="fas fa-phone"></i>
                        Téléphone
                    </label>
                    <div class="input-group">
                        <input type="tel" id="phone" name="phone" 
                               value="{{ old('phone', $professor->phone) }}">
                    </div>
                </div>

                <div class="form-group">
                    <label for="specialty_id">
                        <i class="fas fa-graduation-cap"></i>
                        Spécialité
                    </label>
                    <div class="input-group">
                        <select name="specialty_id" id="specialty_id" required>
                            <option value="">Sélectionnez une spécialité</option>
                            @foreach($specialties as $specialty)
                                <option value="{{ $specialty->id }}" 
                                    {{ old('specialty_id', $professor->specialty_id) == $specialty->id ? 'selected' : '' }}>
                                    {{ $specialty->description }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="type">
                        <i class="fas fa-user-tag"></i>
                        Type
                    </label>
                    <div class="input-group">
                        <select name="type" id="type" required>
                            <option value="permanent" {{ old('type', $professor->type) == 'permanent' ? 'selected' : '' }}>Permanent</option>
                            <option value="vacataire" {{ old('type', $professor->type) == 'vacataire' ? 'selected' : '' }}>Vacataire</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-group checkbox-group">
                <label class="toggle-switch">
                    <input type="checkbox" name="is_active" value="1" 
                           {{ old('is_active', $professor->is_active) ? 'checked' : '' }}>
                    <span class="toggle-slider"></span>
                    <span class="toggle-label">Professeur actif</span>
                </label>
            </div>

            <div class="form-actions">
                <button type="button" class="btn-danger" onclick="confirmDelete()">
                    <i class="fas fa-trash"></i>
                    <span>Supprimer</span>
                </button>
                <div class="action-group">
                    <button type="reset" class="btn-secondary">
                        <i class="fas fa-undo"></i>
                        <span>Réinitialiser</span>
                    </button>
                    <button type="submit" class="btn-primary">
                        <i class="fas fa-save"></i>
                        <span>Enregistrer</span>
                    </button>
                </div>
            </div>
        </form>

        <form id="delete-form" action="{{ route('professors.destroy', ['id' => $professor->id]) }}" method="POST" class="hidden">
            @csrf
            @method('DELETE')
        </form>
    </div>
</div>

@push('styles')
<style>
.form-container {
    max-width: 800px;
    margin: 0 auto;
    padding: 2rem;
}

.form-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
}

.header-content h1 {
    font-size: 1.75rem;
    font-weight: 600;
    color: var(--gray-900);
    margin-bottom: 0.5rem;
}

.text-subtitle {
    color: var(--gray-500);
    font-size: 0.875rem;
}

.back-button {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    color: var(--gray-600);
    text-decoration: none;
    border-radius: 0.5rem;
    transition: all 0.2s;
    background: var(--gray-100);
}

.back-button:hover {
    background: var(--gray-200);
    color: var(--gray-900);
    transform: translateX(-2px);
}

.card {
    background: white;
    border-radius: 1rem;
    padding: 2rem;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
}

.form-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-group label {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.875rem;
    font-weight: 500;
    color: var(--gray-700);
    margin-bottom: 0.5rem;
}

.form-group label i {
    color: var(--primary);
    font-size: 1rem;
}

.input-group {
    position: relative;
    display: flex;
    align-items: center;
    border: 2px solid var(--gray-200);
    border-radius: 0.5rem;
    transition: all 0.2s;
}

.input-group input,
.input-group select {
    width: 100%;
    padding: 0.75rem;
    border: none;
    outline: none;
    background: white;
    color: var(--gray-900);
    font-size: 0.875rem;
}

.input-group select {
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%236B7280'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 0.75rem center;
    background-size: 1.25rem;
    padding-right: 2.5rem;
}

.input-group:focus-within {
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.1);
}

.checkbox-group {
    margin-top: 1.5rem;
}

.toggle-switch {
    position: relative;
    display: inline-flex;
    align-items: center;
    cursor: pointer;
    padding: 0.5rem;
    gap: 0.75rem;
}

.toggle-switch input {
    opacity: 0;
    width: 0;
    height: 0;
}

.toggle-slider {
    position: relative;
    width: 3rem;
    height: 1.5rem;
    background: var(--gray-300);
    border-radius: 999px;
    transition: all 0.2s;
}

.toggle-slider:before {
    content: '';
    position: absolute;
    height: 1.25rem;
    width: 1.25rem;
    left: 0.125rem;
    bottom: 0.125rem;
    background: white;
    border-radius: 50%;
    transition: all 0.2s;
}

.toggle-switch input:checked + .toggle-slider {
    background: var(--primary);
}

.toggle-switch input:checked + .toggle-slider:before {
    transform: translateX(1.5rem);
}

.toggle-label {
    font-size: 0.875rem;
    color: var(--gray-700);
}

.form-actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 2rem;
    padding-top: 2rem;
    border-top: 1px solid var(--gray-200);
}

.action-group {
    display: flex;
    gap: 1rem;
}

.btn-primary,
.btn-secondary,
.btn-danger {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 0.5rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s;
}

.btn-primary {
    background: var(--primary);
    color: white;
}

.btn-secondary {
    background: var(--gray-100);
    color: var(--gray-700);
}

.btn-danger {
    background: var(--danger);
    color: white;
}

.btn-primary:hover,
.btn-secondary:hover,
.btn-danger:hover {
    transform: translateY(-1px);
}

.btn-primary:hover {
    background: var(--primary-dark);
}

.btn-secondary:hover {
    background: var(--gray-200);
}

.btn-danger:hover {
    background: #DC2626;
}

.alert {
    padding: 1rem;
    border-radius: 0.5rem;
    margin-bottom: 1.5rem;
}

.alert-danger {
    background: #FEF2F2;
    border: 1px solid #FCA5A5;
}

.alert-title {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #991B1B;
    font-weight: 500;
    margin-bottom: 0.5rem;
}

.alert-danger ul {
    margin: 0;
    padding-left: 1.5rem;
    color: #991B1B;
}

.hidden {
    display: none;
}

.header-actions {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.btn-add {
    display: inline-flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.75rem 1.5rem;
    background: var(--primary);
    color: white;
    border-radius: 0.5rem;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.2s;
    box-shadow: 0 2px 4px rgba(124, 58, 237, 0.1);
}

.btn-add:hover {
    background: var(--primary-dark);
    transform: translateY(-1px);
    box-shadow: 0 4px 6px rgba(124, 58, 237, 0.2);
}

.btn-add i {
    font-size: 1.1rem;
}

@media (max-width: 768px) {
    .form-container {
        padding: 1rem;
    }

    .form-grid {
        grid-template-columns: 1fr;
    }

    .form-header {
        flex-direction: column;
        gap: 1rem;
    }

    .back-button {
        width: 100%;
        justify-content: center;
    }

    .form-actions {
        flex-direction: column;
        gap: 1rem;
    }

    .action-group {
        width: 100%;
        flex-direction: column;
    }

    .btn-primary,
    .btn-secondary,
    .btn-danger {
        width: 100%;
        justify-content: center;
    }

    .header-actions {
        flex-direction: column;
        width: 100%;
        gap: 0.75rem;
    }

    .btn-add {
        width: 100%;
        justify-content: center;
    }
}
</style>
@endpush

@push('scripts')
<script>
function confirmDelete() {
    if (confirm('Êtes-vous sûr de vouloir supprimer ce professeur ?')) {
        document.getElementById('delete-form').submit();
    }
}
</script>
@endpush 