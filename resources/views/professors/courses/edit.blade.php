@extends('layouts.dashboard')

@section('title', 'Modifier le Cours')

@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <div class="header-wrapper">
            <div class="header-content">
                <h1><i class="fas fa-edit"></i> Modifier le Cours</h1>
                <p class="text-subtitle">Modifier les informations du cours</p>
            </div>
            <div class="header-actions">
                <a href="{{ route('professor.courses.index') }}" class="btn-secondary">
                    <i class="fas fa-arrow-left"></i>
                    Retour à la liste
                </a>
            </div>
        </div>
    </div>

    <div class="content-card">
        <div class="card-body">
            <form action="{{ route('professor.courses.update', $course->id) }}" method="POST" class="edit-form">
                @csrf
                @method('PUT')
                
                <div class="form-group">
                    <label for="title">Titre du cours</label>
                    <div class="input-wrapper">
                        <i class="fas fa-book icon"></i>
                        <input type="text" 
                               id="title" 
                               name="title" 
                               class="form-control @error('title') is-invalid @enderror"
                               value="{{ old('title', $course->title) }}" 
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
                                    <option value="{{ $subject->id }}" {{ old('subject_id', $course->subject_id) == $subject->id ? 'selected' : '' }}>
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
                                    <option value="{{ $class->id }}" {{ old('class_id', $course->class_id) == $class->id ? 'selected' : '' }}>
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
                                <option value="S1" {{ old('semester', $course->semester) == 'S1' ? 'selected' : '' }}>S1</option>
                                <option value="S2" {{ old('semester', $course->semester) == 'S2' ? 'selected' : '' }}>S2</option>
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
                                   value="{{ old('hours', $course->hours) }}" 
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
</div>

@push('styles')
<style>
/* Base Styles */
.content-wrapper {
    padding: 2rem;
    background-color: #F3F4F6;
    min-height: calc(100vh - 64px);
}

/* Header Styles */
.page-header {
    margin-bottom: 2rem;
    background: white;
    padding: 1.5rem;
    border-radius: 1rem;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
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
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.header-content h1 i {
    color: #4F46E5;
    font-size: 1.75rem;
}

.text-subtitle {
    color: #6B7280;
    font-size: 0.875rem;
}

/* Card Styles */
.content-card {
    background: white;
    border-radius: 1rem;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    overflow: hidden;
}

.card-body {
    padding: 2rem;
}

/* Form Styles */
.edit-form {
    max-width: 800px;
    margin: 0 auto;
}

.form-row {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1.5rem;
    margin-bottom: 1.5rem;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-group label {
    display: block;
    font-weight: 500;
    color: #374151;
    margin-bottom: 0.75rem;
    font-size: 0.875rem;
}

/* Input Styles */
.input-wrapper, .select-wrapper {
    position: relative;
}

.icon {
    position: absolute;
    left: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: #6B7280;
    font-size: 1rem;
}

.form-control {
    width: 100%;
    padding: 0.875rem 1rem 0.875rem 2.75rem;
    border: 1px solid #D1D5DB;
    border-radius: 0.5rem;
    font-size: 0.875rem;
    transition: all 0.2s;
    background-color: #F9FAFB;
}

.form-control:hover {
    border-color: #9CA3AF;
}

.form-control:focus {
    border-color: #4F46E5;
    box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
    outline: none;
    background-color: white;
}

/* Select Styles */
.select-wrapper .arrow {
    position: absolute;
    right: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: #6B7280;
    pointer-events: none;
    transition: transform 0.2s;
}

.select-wrapper select:focus + .arrow {
    transform: translateY(-50%) rotate(180deg);
}

/* Button Styles */
.form-actions {
    display: flex;
    justify-content: flex-end;
    gap: 1rem;
    margin-top: 2.5rem;
    padding-top: 1.5rem;
    border-top: 1px solid #E5E7EB;
}

.btn-primary, .btn-secondary {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    border-radius: 0.5rem;
    font-weight: 500;
    font-size: 0.875rem;
    transition: all 0.2s;
    cursor: pointer;
}

.btn-primary {
    background: #4F46E5;
    color: white;
    border: none;
}

.btn-primary:hover {
    background: #4338CA;
    transform: translateY(-1px);
    box-shadow: 0 4px 6px -1px rgba(79, 70, 229, 0.1);
}

.btn-secondary {
    background: #F3F4F6;
    color: #374151;
    border: 1px solid #D1D5DB;
}

.btn-secondary:hover {
    background: #E5E7EB;
    transform: translateY(-1px);
}

/* Validation Styles */
.invalid-feedback {
    color: #DC2626;
    font-size: 0.75rem;
    margin-top: 0.5rem;
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

.invalid-feedback::before {
    content: '⚠';
    font-size: 0.875rem;
}

.is-invalid {
    border-color: #DC2626;
    background-color: #FEF2F2;
}

.is-invalid:focus {
    border-color: #DC2626;
    box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1);
}

/* Responsive Design */
@media (max-width: 768px) {
    .content-wrapper {
        padding: 1rem;
    }

    .page-header {
        padding: 1rem;
    }

    .form-row {
        grid-template-columns: 1fr;
    }

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

    .card-body {
        padding: 1.5rem;
    }
}

/* Animations */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

.content-card {
    animation: fadeIn 0.3s ease-out;
}

/* Dark Mode Support */
@media (prefers-color-scheme: dark) {
    .content-wrapper {
        background-color: #1F2937;
    }

    .page-header, .content-card {
        background-color: #111827;
    }

    .header-content h1 {
        color: #F9FAFB;
    }

    .text-subtitle {
        color: #9CA3AF;
    }

    .form-control {
        background-color: #374151;
        border-color: #4B5563;
        color: #F9FAFB;
    }

    .form-control:focus {
        background-color: #4B5563;
    }

    .btn-secondary {
        background-color: #374151;
        border-color: #4B5563;
        color: #F9FAFB;
    }

    .btn-secondary:hover {
        background-color: #4B5563;
    }
}
</style>
@endpush
@endsection 