@extends('layouts.dashboard')

@section('title', 'Modifier le Cours')

@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <div class="header-wrapper">
            <div class="header-content">
                <h1>Modifier le Cours</h1>
                <p class="text-subtitle">Modifier les informations du cours</p>
            </div>
        </div>
    </div>

    <div class="content-grid">
        <div class="content-card">
            <div class="card-body">
                <form action="{{ route('professor.courses.update', $course) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="form-group">
                        <label for="title">Titre du cours</label>
                        <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $course->title) }}" required>
                    </div>

                    <div class="form-group">
                        <label for="subject_id">Matière</label>
                        <select name="subject_id" id="subject_id" class="form-control" required>
                            <option value="">Sélectionner une matière</option>
                            @foreach($subjects as $subject)
                                <option value="{{ $subject->id }}" {{ old('subject_id', $course->subject_id) == $subject->id ? 'selected' : '' }}>
                                    {{ $subject->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="class_id">Classe</label>
                        <select name="class_id" id="class_id" class="form-control" required>
                            <option value="">Sélectionner une classe</option>
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}" {{ old('class_id', $course->class_id) == $class->id ? 'selected' : '' }}>
                                    {{ $class->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="semester">Semestre</label>
                        <select name="semester" id="semester" class="form-control" required>
                            <option value="S1" {{ old('semester', $course->semester) == 'S1' ? 'selected' : '' }}>S1</option>
                            <option value="S2" {{ old('semester', $course->semester) == 'S2' ? 'selected' : '' }}>S2</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="hours">Nombre d'heures</label>
                        <input type="number" name="hours" id="hours" class="form-control" value="{{ old('hours', $course->hours) }}" min="1" required>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn-primary">
                            <i class="fas fa-save"></i>
                            Enregistrer les modifications
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
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
        border: 2px solid #E5E7EB;
        border-radius: 0.5rem;
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px var(--primary-light);
    }

    .form-actions {
        margin-top: 2rem;
        display: flex;
        justify-content: flex-end;
    }
</style>
@endpush
@endsection 