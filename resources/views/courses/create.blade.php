@extends('layouts.dashboard')

@section('title', 'Nouveau Cours')

@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <h1>Nouveau Cours</h1>
        <p class="text-subtitle">Ajouter un nouveau cours</p>
    </div>

    <div class="card">
        <form action="{{ route('courses.store') }}" method="POST" class="create-form">
            @csrf
            
            <div class="form-group">
                <label for="title">Titre du cours</label>
                <div class="input-wrapper">
                    <i class="fas fa-book icon"></i>
                    <input type="text" 
                           id="title" 
                           name="title" 
                           class="form-control @error('title') is-invalid @enderror"
                           value="{{ old('title') }}" 
                           required>
                </div>
                @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="subject_id">Matière</label>
                    <div class="select-wrapper">
                        <i class="fas fa-graduation-cap icon"></i>
                        <select name="subject_id" 
                                id="subject_id" 
                                class="form-control @error('subject_id') is-invalid @enderror" 
                                required>
                            <option value="">Sélectionnez une matière</option>
                            @foreach($subjects as $subject)
                                <option value="{{ $subject->id }}" {{ old('subject_id') == $subject->id ? 'selected' : '' }}>
                                    {{ $subject->name }}
                                </option>
                            @endforeach
                        </select>
                        <i class="fas fa-chevron-down arrow"></i>
                    </div>
                    @error('subject_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group col-md-6">
                    <label for="class_id">Classe</label>
                    <div class="select-wrapper">
                        <i class="fas fa-users icon"></i>
                        <select name="class_id" 
                                id="class_id" 
                                class="form-control @error('class_id') is-invalid @enderror" 
                                required>
                            <option value="">Sélectionnez une classe</option>
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>
                                    {{ $class->name }}
                                </option>
                            @endforeach
                        </select>
                        <i class="fas fa-chevron-down arrow"></i>
                    </div>
                    @error('class_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="semester">Semestre</label>
                    <div class="select-wrapper">
                        <i class="fas fa-calendar icon"></i>
                        <select name="semester" 
                                id="semester" 
                                class="form-control @error('semester') is-invalid @enderror" 
                                required>
                            <option value="">Sélectionnez un semestre</option>
                            <option value="S1" {{ old('semester') == 'S1' ? 'selected' : '' }}>S1</option>
                            <option value="S2" {{ old('semester') == 'S2' ? 'selected' : '' }}>S2</option>
                        </select>
                        <i class="fas fa-chevron-down arrow"></i>
                    </div>
                    @error('semester')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group col-md-6">
                    <label for="hours">Nombre d'heures</label>
                    <div class="input-wrapper">
                        <i class="fas fa-clock icon"></i>
                        <input type="number" 
                               id="hours" 
                               name="hours" 
                               class="form-control @error('hours') is-invalid @enderror"
                               value="{{ old('hours') }}" 
                               min="1"
                               required>
                    </div>
                    @error('hours')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
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