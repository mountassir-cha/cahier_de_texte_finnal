@extends('layouts.dashboard')

@section('title', 'Modifier le Cours')

@section('content')
<div class="content-header">
    <h1>Modifier le Cours</h1>
    <a href="{{ route('courses.index') }}" class="btn btn-primary">
        <i class="fas fa-arrow-left"></i>
        <span>Retour</span>
    </a>
</div>

<div class="content-body">
    <div class="card">
        <div class="card-body">
            <form action="{{ route('courses.update', $course) }}" method="POST">
                @csrf
                @method('PUT')
                
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="form-row">
                    <div class="form-group">
                        <label for="title">Titre</label>
                        <div class="input-group">
                            <i class="fas fa-heading"></i>
                            <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $course->title) }}" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="professor_id">Professeur</label>
                        <div class="input-group">
                            <i class="fas fa-user-tie"></i>
                            <select name="professor_id" id="professor_id" class="form-control" required>
                                <option value="">Sélectionnez un professeur</option>
                                @foreach($professors as $professor)
                                    <option value="{{ $professor->id }}" {{ old('professor_id', $course->professor_id) == $professor->id ? 'selected' : '' }}>
                                        {{ $professor->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="subject_id">Matière</label>
                        <div class="input-group">
                            <i class="fas fa-book"></i>
                            <select name="subject_id" id="subject_id" class="form-control" required>
                                <option value="">Sélectionnez une matière</option>
                                @foreach($subjects as $subject)
                                    <option value="{{ $subject->id }}" {{ old('subject_id', $course->subject_id) == $subject->id ? 'selected' : '' }}>
                                        {{ $subject->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="class_id">Classe</label>
                        <div class="input-group">
                            <i class="fas fa-chalkboard"></i>
                            <select name="class_id" id="class_id" class="form-control" required>
                                <option value="">Sélectionnez une classe</option>
                                @foreach($classes as $class)
                                    <option value="{{ $class->id }}" {{ old('class_id', $course->class_id) == $class->id ? 'selected' : '' }}>
                                        {{ $class->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="semester">Semestre</label>
                        <div class="input-group">
                            <i class="fas fa-calendar"></i>
                            <input type="text" name="semester" id="semester" class="form-control" value="{{ old('semester', $course->semester) }}" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="hours">Heures</label>
                        <div class="input-group">
                            <i class="fas fa-clock"></i>
                            <input type="number" name="hours" id="hours" class="form-control" value="{{ old('hours', $course->hours) }}" min="1" required>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <div class="input-group">
                        <i class="fas fa-align-left"></i>
                        <textarea name="description" id="description" class="form-control" rows="3">{{ old('description', $course->description) }}</textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label class="checkbox-label">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $course->is_active) ? 'checked' : '' }}>
                        Cours actif
                    </label>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-success">
                        <i class="fas fa-save"></i>
                        <span>Mettre à jour</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
}

.input-group textarea {
    min-height: 100px;
    resize: vertical;
}

.checkbox-label {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    cursor: pointer;
}

.checkbox-label input[type="checkbox"] {
    width: 1rem;
    height: 1rem;
}

.form-actions {
    margin-top: 2rem;
    display: flex;
    justify-content: flex-end;
}

.btn-success {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    background: var(--success);
    color: white;
    border: none;
    border-radius: 0.5rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-success:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.2);
}

@media (max-width: 640px) {
    .form-row {
        grid-template-columns: 1fr;
    }
}
</style>
@endpush 