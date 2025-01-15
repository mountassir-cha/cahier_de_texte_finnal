@extends('layouts.dashboard')

@section('title', 'Nouvelle Matière')

@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <h1>Nouvelle Matière</h1>
        <p class="text-subtitle">Ajouter une nouvelle matière</p>
    </div>

    <div class="card">
        <form action="{{ route('subjects.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="name">Nom</label>
                <input type="text" 
                       class="form-control @error('name') is-invalid @enderror" 
                       id="name" 
                       name="name" 
                       value="{{ old('name') }}" 
                       required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control @error('description') is-invalid @enderror" 
                          id="description" 
                          name="description" 
                          rows="4">{{ old('description') }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="credits">Crédits</label>
                <input type="number" 
                       class="form-control @error('credits') is-invalid @enderror" 
                       id="credits" 
                       name="credits" 
                       value="{{ old('credits') }}" 
                       required>
                @error('credits')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="code">Code</label>
                <input type="text" 
                       class="form-control @error('code') is-invalid @enderror" 
                       id="code" 
                       name="code" 
                       value="{{ old('code') }}" 
                       required>
                @error('code')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <div class="custom-control custom-switch">
                    <input type="checkbox" 
                           class="custom-control-input" 
                           id="is_active" 
                           name="is_active" 
                           {{ old('is_active') ? 'checked' : '' }}>
                    <label class="custom-control-label" for="is_active">Matière active</label>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Enregistrer</button>
                <a href="{{ route('subjects.index') }}" class="btn btn-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>

@push('styles')
<style>
.card {
    background: white;
    border-radius: 1rem;
    padding: 2rem;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    margin-bottom: 2rem;
    max-width: 800px;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-group label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 500;
    color: #374151;
}

.form-control {
    width: 100%;
    padding: 0.75rem 1rem;
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

textarea.form-control {
    resize: vertical;
    min-height: 100px;
}

input[type="number"].form-control {
    width: 150px;
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
    padding-top: 1rem;
    border-top: 1px solid #E5E7EB;
}

.btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0.75rem 1.5rem;
    border-radius: 0.5rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s;
    border: none;
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
@media (max-width: 640px) {
    .card {
        padding: 1.5rem;
        margin: 1rem;
    }

    .form-actions {
        flex-direction: column;
    }

    .btn {
        width: 100%;
    }
}
</style>
@endpush
@endsection 