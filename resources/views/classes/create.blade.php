@extends('layouts.dashboard')

@section('title', 'Ajouter une Nouvelle Classe')

@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <div class="header-wrapper">
            <div class="header-content">
                <h1>Ajouter une Nouvelle Classe</h1>
                <p class="text-subtitle">Créez une nouvelle classe dans le système</p>
            </div>
            <div class="header-actions">
                <a href="{{ route('classes.index') }}" class="btn-secondary">
                    <i class="fas fa-arrow-left"></i>
                    Retour à la liste
                </a>
            </div>
        </div>
    </div>

    <div class="content-card">
        <div class="card-body">
            <form action="{{ route('classes.store') }}" method="POST" class="create-form">
                @csrf
                
                <div class="form-group">
                    <label for="name">Nom de la Classe</label>
                    <div class="input-wrapper">
                        <i class="fas fa-users icon"></i>
                        <input type="text" 
                               id="name" 
                               name="name" 
                               class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name') }}" 
                               placeholder="Ex: Groupe 1, Classe A..."
                               required>
                    </div>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="level">Niveau</label>
                    <div class="select-wrapper">
                        <i class="fas fa-graduation-cap icon"></i>
                        <select name="level" 
                                id="level" 
                                class="form-control @error('level') is-invalid @enderror" 
                                required>
                            <option value="">Sélectionnez un niveau</option>
                            <option value="1ère année">1ère année</option>
                            <option value="2ème année">2ème année</option>
                            <option value="3ème année">3ème année</option>
                            <option value="4ème année">4ème année</option>
                            <option value="5ème année">5ème année</option>
                        </select>
                        <i class="fas fa-chevron-down arrow"></i>
                    </div>
                    @error('level')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="capacity">Capacité</label>
                    <div class="input-wrapper">
                        <i class="fas fa-user-friends icon"></i>
                        <input type="number" 
                               id="capacity" 
                               name="capacity" 
                               class="form-control @error('capacity') is-invalid @enderror"
                               value="{{ old('capacity') }}" 
                               min="1"
                               placeholder="Nombre d'étudiants maximum"
                               required>
                    </div>
                    @error('capacity')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group checkbox-group">
                    <label class="checkbox-container">
                        <input type="checkbox" 
                               name="is_active" 
                               id="is_active" 
                               value="1" 
                               {{ old('is_active', true) ? 'checked' : '' }}>
                        <span class="checkmark"></span>
                        Classe active
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
.content-wrapper {
    padding: 2rem;
}

.page-header {
    margin-bottom: 2rem;
}

.header-wrapper {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.header-content h1 {
    font-size: 1.875rem;
    font-weight: 600;
    color: #111827;
    margin-bottom: 0.5rem;
}

.text-subtitle {
    color: #6B7280;
    font-size: 0.875rem;
}

.content-card {
    background: white;
    border-radius: 0.5rem;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.card-body {
    padding: 2rem;
}

.create-form {
    max-width: 600px;
    margin: 0 auto;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-group label {
    display: block;
    font-weight: 500;
    color: #374151;
    margin-bottom: 0.5rem;
}

.input-wrapper, .select-wrapper {
    position: relative;
}

.icon {
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
    border-radius: 0.375rem;
    font-size: 0.875rem;
    transition: all 0.2s;
}

.form-control:focus {
    border-color: #4F46E5;
    box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
    outline: none;
}

.select-wrapper .arrow {
    position: absolute;
    right: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: #6B7280;
    pointer-events: none;
}

.checkbox-group {
    margin-top: 2rem;
}

.checkbox-container {
    display: flex;
    align-items: center;
    cursor: pointer;
    user-select: none;
}

.checkbox-container input {
    position: absolute;
    opacity: 0;
    cursor: pointer;
    height: 0;
    width: 0;
}

.checkmark {
    height: 1.25rem;
    width: 1.25rem;
    background-color: #fff;
    border: 2px solid #D1D5DB;
    border-radius: 0.25rem;
    margin-right: 0.5rem;
    position: relative;
    transition: all 0.2s;
}

.checkbox-container:hover input ~ .checkmark {
    border-color: #4F46E5;
}

.checkbox-container input:checked ~ .checkmark {
    background-color: #4F46E5;
    border-color: #4F46E5;
}

.checkmark:after {
    content: "";
    position: absolute;
    display: none;
    left: 6px;
    top: 2px;
    width: 5px;
    height: 10px;
    border: solid white;
    border-width: 0 2px 2px 0;
    transform: rotate(45deg);
}

.checkbox-container input:checked ~ .checkmark:after {
    display: block;
}

.form-actions {
    display: flex;
    justify-content: flex-end;
    gap: 1rem;
    margin-top: 2rem;
    padding-top: 1.5rem;
    border-top: 1px solid #E5E7EB;
}

.btn-primary, .btn-secondary {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    border-radius: 0.375rem;
    font-weight: 500;
    font-size: 0.875rem;
    transition: all 0.2s;
}

.btn-primary {
    background: #4F46E5;
    color: white;
    border: none;
}

.btn-primary:hover {
    background: #4338CA;
}

.btn-secondary {
    background: #F3F4F6;
    color: #374151;
    border: 1px solid #D1D5DB;
}

.btn-secondary:hover {
    background: #E5E7EB;
}

.invalid-feedback {
    color: #DC2626;
    font-size: 0.75rem;
    margin-top: 0.25rem;
}

.is-invalid {
    border-color: #DC2626;
}

.is-invalid:focus {
    border-color: #DC2626;
    box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1);
}

@media (max-width: 640px) {
    .header-wrapper {
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
    }

    .form-actions {
        flex-direction: column;
    }

    .btn-primary, .btn-secondary {
        width: 100%;
        justify-content: center;
    }
}
</style>
@endpush
@endsection 