@extends('layouts.dashboard')

@section('title', 'Modifier la Classe')

@section('content')
<div class="form-container">
    <div class="form-header">
        <div class="header-content">
            <h1>Modifier la Classe</h1>
            <p class="text-subtitle">Modification de la classe {{ $class->name }}</p>
        </div>
        <a href="{{ route('classes.index') }}" class="back-button">
            <i class="fas fa-arrow-left"></i>
            <span>Retour à la liste</span>
        </a>
    </div>

    <div class="card">
        <form action="{{ route('classes.update', ['id' => $class->id]) }}" method="POST">
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
                    <label for="name">
                        <i class="fas fa-chalkboard"></i>
                        Nom de la Classe
                    </label>
                    <div class="input-group">
                        <input type="text" id="name" name="name" value="{{ old('name', $class->name) }}" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="level">
                        <i class="fas fa-layer-group"></i>
                        Niveau
                    </label>
                    <div class="input-group">
                        <select name="level" id="level" required>
                            <option value="">Sélectionnez un niveau</option>
                            <option value="1ère année" {{ old('level', $class->level) == '1ère année' ? 'selected' : '' }}>1ère année</option>
                            <option value="2ème année" {{ old('level', $class->level) == '2ème année' ? 'selected' : '' }}>2ème année</option>
                            <option value="3ème année" {{ old('level', $class->level) == '3ème année' ? 'selected' : '' }}>3ème année</option>
                            <option value="4ème année" {{ old('level', $class->level) == '4ème année' ? 'selected' : '' }}>4ème année</option>
                            <option value="5ème année" {{ old('level', $class->level) == '5ème année' ? 'selected' : '' }}>5ème année</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="capacity">
                        <i class="fas fa-users"></i>
                        Capacité
                    </label>
                    <div class="input-group">
                        <input type="number" id="capacity" name="capacity" value="{{ old('capacity', $class->capacity) }}" min="1" required>
                        <span class="input-suffix">étudiants</span>
                    </div>
                </div>
            </div>

            <div class="form-group checkbox-group">
                <label class="toggle-switch">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $class->is_active) ? 'checked' : '' }}>
                    <span class="toggle-slider"></span>
                    <span class="toggle-label">Classe active</span>
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

        <form id="delete-form" action="{{ route('classes.destroy', ['id' => $class->id]) }}" method="POST" class="hidden">
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
    -webkit-appearance: none;
    -moz-appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%236B7280'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 0.75rem center;
    background-size: 1.25rem;
    padding-right: 2.5rem;
}

.input-suffix {
    padding-right: 0.75rem;
    color: var(--gray-500);
    font-size: 0.875rem;
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
}
</style>
@endpush

@push('scripts')
<script>
function confirmDelete() {
    if (confirm('Êtes-vous sûr de vouloir supprimer cette classe ?')) {
        document.getElementById('delete-form').submit();
    }
}
</script>
@endpush 