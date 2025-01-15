@extends('layouts.dashboard')

@section('title', 'Gestion des Cours')

@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <div class="header-wrapper">
            <div class="header-content">
                <h1>Gestion des Cours</h1>
                <p class="text-subtitle">Gérez vos cours et leur contenu</p>
            </div>
            <div class="header-actions">
                <a href="{{ route('professor.courses.create') }}" class="btn-primary">
                    <i class="fas fa-plus"></i>
                    Nouveau Cours
                </a>
            </div>
        </div>
    </div>

    <div class="content-grid">
        <div class="content-card">
            <div class="card-body">
                @if($courses->count() > 0)
                    <div class="course-list">
                        @foreach($courses as $course)
                            <div class="course-item">
                                <div class="course-info">
                                    <div class="course-header">
                                        <h3 class="course-title">{{ $course->title }}</h3>
                                        <span class="course-semester">{{ $course->semester }}</span>
                                    </div>
                                    <div class="course-details">
                                        <div class="detail-group">
                                            <span class="detail-label">
                                                <i class="fas fa-users"></i>
                                                Classe:
                                            </span>
                                            <span class="detail-value">{{ $course->classe->name }}</span>
                                        </div>
                                        <div class="detail-group">
                                            <span class="detail-label">
                                                <i class="fas fa-book"></i>
                                                Matière:
                                            </span>
                                            <span class="detail-value">{{ $course->subject->name }}</span>
                                        </div>
                                        <div class="detail-group">
                                            <span class="detail-label">
                                                <i class="fas fa-clock"></i>
                                                Volume horaire:
                                            </span>
                                            <span class="detail-value">{{ $course->hours }}h</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="course-actions">
                                    <a href="{{ route('professor.courses.edit', $course) }}" class="btn-icon edit" title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('professor.courses.delete', $course) }}" method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce cours ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-icon delete" title="Supprimer">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state">
                        <i class="fas fa-book"></i>
                        <p>Aucun cours disponible</p>
                        <a href="{{ route('professor.courses.create') }}" class="btn-primary">
                            <i class="fas fa-plus"></i>
                            Ajouter un cours
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .course-list {
        display: grid;
        gap: 1rem;
    }

    .course-item {
        background: white;
        border-radius: 1rem;
        padding: 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .course-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .course-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1rem;
    }

    .course-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #1F2937;
        margin: 0;
    }

    .course-semester {
        background: var(--primary-light);
        color: var(--primary);
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.875rem;
        font-weight: 500;
    }

    .course-details {
        display: grid;
        gap: 0.75rem;
    }

    .detail-group {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .detail-label {
        color: #6B7280;
        font-size: 0.875rem;
        display: flex;
        align-items: center;
        gap: 0.375rem;
        min-width: 100px;
    }

    .detail-value {
        color: #374151;
        font-weight: 500;
    }

    .course-actions {
        display: flex;
        gap: 0.5rem;
    }

    .btn-icon {
        width: 2.5rem;
        height: 2.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 0.5rem;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-icon.edit {
        background: #EEF2FF;
        color: #4F46E5;
    }

    .btn-icon.delete {
        background: #FEE2E2;
        color: #DC2626;
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

    .empty-state p {
        margin-bottom: 1.5rem;
    }

    @media (max-width: 768px) {
        .course-item {
            flex-direction: column;
            gap: 1rem;
        }

        .course-actions {
            width: 100%;
            justify-content: flex-end;
            padding-top: 1rem;
            border-top: 1px solid #E5E7EB;
        }
    }
</style>
@endpush
@endsection 