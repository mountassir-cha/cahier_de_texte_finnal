@extends('layouts.dashboard')

@section('title', 'Nouveau Cours')

@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <h1>Nouveau Cours</h1>
        <p class="text-subtitle">Ajouter un nouveau cours</p>
    </div>

    <div class="card">
        <form action="{{ route('courses.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="title">Titre</label>
                <input type="text" 
                       class="form-control @error('title') is-invalid @enderror" 
                       id="title" 
                       name="title" 
                       value="{{ old('title') }}" 
                       required>
                @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="professor_id">Professeur</label>
                    <select class="form-control @error('professor_id') is-invalid @enderror" 
                            id="professor_id" 
                            name="professor_id" 
                            required>
                        <option value="">Sélectionnez un professeur</option>
                        @foreach($professors as $professor)
                            <option value="{{ $professor->id }}" {{ old('professor_id') == $professor->id ? 'selected' : '' }}>
                                {{ $professor->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('professor_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group col-md-6">
                    <label for="subject_id">Matière</label>
                    <select class="form-control @error('subject_id') is-invalid @enderror" 
                            id="subject_id" 
                            name="subject_id" 
                            required>
                        <option value="">Sélectionnez une matière</option>
                        @foreach($subjects as $subject)
                            <option value="{{ $subject->id }}" {{ old('subject_id') == $subject->id ? 'selected' : '' }}>
                                {{ $subject->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('subject_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="classe_id">Classe</label>
                    <select class="form-control @error('classe_id') is-invalid @enderror" 
                            id="classe_id" 
                            name="classe_id" 
                            required>
                        <option value="">Sélectionnez une classe</option>
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}" {{ old('classe_id') == $class->id ? 'selected' : '' }}>
                                {{ $class->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('classe_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group col-md-3">
                    <label for="semester">Semestre</label>
                    <select class="form-control @error('semester') is-invalid @enderror" 
                            id="semester" 
                            name="semester" 
                            required>
                        <option value="1" {{ old('semester') == 1 ? 'selected' : '' }}>Semestre 1</option>
                        <option value="2" {{ old('semester') == 2 ? 'selected' : '' }}>Semestre 2</option>
                    </select>
                    @error('semester')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group col-md-3">
                    <label for="hours">Heures</label>
                    <input type="number" 
                           class="form-control @error('hours') is-invalid @enderror" 
                           id="hours" 
                           name="hours" 
                           value="{{ old('hours') }}" 
                           required>
                    @error('hours')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <div class="custom-control custom-switch">
                    <input type="checkbox" 
                           class="custom-control-input" 
                           id="is_active" 
                           name="is_active" 
                           {{ old('is_active', true) ? 'checked' : '' }}>
                    <label class="custom-control-label" for="is_active">Cours actif</label>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Enregistrer</button>
                <a href="{{ route('courses.index') }}" class="btn btn-secondary">Annuler</a>
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
    max-width: 1000px;
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

.col-md-3 {
    flex: 0 0 calc(25% - 2rem);
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
@media (max-width: 768px) {
    .form-row {
        flex-direction: column;
    }

    .col-md-6, .col-md-3 {
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
    }
}
</style>
@endpush
@endsection 