@extends('layouts.dashboard')

@section('title', 'Liste des Cahiers de Texte')

@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <div class="header-wrapper">
            <div class="header-content">
                <h1>Cahiers de Texte</h1>
                <p class="text-subtitle">Consultez l'historique de vos cahiers de texte</p>
            </div>
            <div class="header-actions">
                <a href="{{ route('professor.cahier-texte') }}" class="btn-primary">
                    <i class="fas fa-plus"></i>
                    Nouveau Cahier
                </a>
            </div>
        </div>
    </div>

    <div class="content-grid">
        <!-- Filtres -->
        <div class="content-card">
            <div class="card-body">
                <form method="GET" class="filters-form">
                    <div class="filters-grid">
                        <div class="form-group">
                            <label for="course_id">Cours</label>
                            <select name="course_id" id="course_id" class="form-control">
                                <option value="">Tous les cours</option>
                                @foreach($courses as $course)
                                    <option value="{{ $course->id }}" {{ request('course_id') == $course->id ? 'selected' : '' }}>
                                        {{ $course->title }} ({{ $course->classe->name }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="date_start">Date début</label>
                            <input type="date" name="date_start" id="date_start" class="form-control" 
                                value="{{ request('date_start') }}">
                        </div>

                        <div class="form-group">
                            <label for="date_end">Date fin</label>
                            <input type="date" name="date_end" id="date_end" class="form-control" 
                                value="{{ request('date_end') }}">
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn-primary">
                                <i class="fas fa-filter"></i>
                                Filtrer
                            </button>
                            <a href="{{ route('professor.cahier-texte.list') }}" class="btn-secondary">
                                <i class="fas fa-times"></i>
                                Réinitialiser
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Liste des cahiers -->
        <div class="content-card">
            <div class="card-body">
                @if($cahierTextes->count() > 0)
                    <div class="cahier-list">
                        @foreach($cahierTextes as $cahier)
                            <div class="cahier-item">
                                <div class="cahier-header">
                                    <div class="cahier-info">
                                        <h3>{{ $cahier->course->title }}</h3>
                                        <span class="cahier-date">{{ $cahier->date->format('d/m/Y') }}</span>
                                    </div>
                                    <div class="cahier-meta">
                                        <span class="badge">{{ $cahier->course->classe->name }}</span>
                                        <span class="badge">{{ $cahier->course->subject->name }}</span>
                                    </div>
                                </div>
                                <div class="cahier-content">
                                    {!! $cahier->content !!}
                                </div>
                                <div class="cahier-actions">
                                    <a href="{{ route('professor.cahier-texte', ['course_id' => $cahier->course_id, 'date' => $cahier->date->format('Y-m-d')]) }}" 
                                        class="btn-icon edit" title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="pagination-wrapper">
                        {{ $cahierTextes->links() }}
                    </div>
                @else
                    <div class="empty-state">
                        <i class="fas fa-book"></i>
                        <p>Aucun cahier de texte trouvé</p>
                        <a href="{{ route('professor.cahier-texte') }}" class="btn-primary">
                            <i class="fas fa-plus"></i>
                            Créer un cahier
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .filters-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
    }

    .cahier-list {
        display: grid;
        gap: 1.5rem;
    }

    .cahier-item {
        background: white;
        border-radius: 0.5rem;
        padding: 1.5rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .cahier-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 1rem;
    }

    .cahier-info h3 {
        margin: 0;
        font-size: 1.25rem;
        color: #1F2937;
    }

    .cahier-date {
        color: #6B7280;
        font-size: 0.875rem;
    }

    .cahier-meta {
        display: flex;
        gap: 0.5rem;
    }

    .badge {
        background: var(--primary-light);
        color: var(--primary);
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.875rem;
    }

    .cahier-content {
        color: #4B5563;
        margin-bottom: 1rem;
        max-height: 200px;
        overflow-y: auto;
    }

    .cahier-actions {
        display: flex;
        justify-content: flex-end;
        gap: 0.5rem;
    }

    .btn-icon {
        width: 2.5rem;
        height: 2.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 0.5rem;
        transition: all 0.3s ease;
    }

    .btn-icon.edit {
        background: #EEF2FF;
        color: #4F46E5;
    }

    .btn-icon:hover {
        transform: translateY(-1px);
    }

    .empty-state {
        text-align: center;
        padding: 3rem 1.5rem;
        color: #6B7280;
    }

    .empty-state i {
        font-size: 3rem;
        margin-bottom: 1rem;
        color: #9CA3AF;
    }

    .pagination-wrapper {
        margin-top: 2rem;
    }

    .btn-secondary {
        background: #F3F4F6;
        color: #374151;
        padding: 0.75rem 1.5rem;
        border-radius: 0.5rem;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
    }

    .btn-secondary:hover {
        background: #E5E7EB;
    }
</style>
@endpush
@endsection 