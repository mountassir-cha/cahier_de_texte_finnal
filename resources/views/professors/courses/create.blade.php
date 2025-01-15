@extends('layouts.dashboard')

@section('title', 'Nouveau Cours')

@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <div class="header-wrapper">
            <div class="header-content">
                <h1>Nouveau Cours</h1>
                <p class="text-subtitle">Créer un nouveau cours</p>
            </div>
        </div>
    </div>

    <div class="content-grid">
        <div class="content-card">
            <div class="card-body">
                <form action="{{ route('professor.courses.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="title">Titre du cours</label>
                        <input type="text" name="title" id="title" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="subject_id">Matière</label>
                        <select name="subject_id" id="subject_id" class="form-control" required>
                            <option value="">Sélectionner une matière</option>
                            @foreach($subjects as $subject)
                                <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="class_id">Classe</label>
                        <select name="class_id" id="class_id" class="form-control" required>
                            <option value="">Sélectionner une classe</option>
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}">{{ $class->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="semester">Semestre</label>
                        <select name="semester" id="semester" class="form-control" required>
                            <option value="S1">S1</option>
                            <option value="S2">S2</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="hours">Nombre d'heures</label>
                        <input type="number" name="hours" id="hours" class="form-control" min="1" required>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn-primary">
                            <i class="fas fa-save"></i>
                            Enregistrer
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