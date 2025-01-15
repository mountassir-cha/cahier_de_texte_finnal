@extends('layouts.dashboard')

@section('title', 'Tableau de Bord Professeur')

@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <div class="header-wrapper">
            <div class="header-content">
                <h1>Bienvenue, {{ Auth::guard('professor')->user()->name }}</h1>
                <p class="text-subtitle">Gérez vos cours et suivez vos classes</p>
            </div>
        </div>
    </div>

    <div class="dashboard-grid">
        <!-- Card Cours -->
        <div class="dashboard-card">
            <div class="card-icon courses">
                <i class="fas fa-graduation-cap"></i>
            </div>
            <div class="card-content">
                <div class="card-title">Cours</div>
                <div class="card-number">{{ $courses->count() }}</div>
                <div class="card-label">Enseignés</div>
            </div>
        </div>

        <!-- Card Classes -->
        <div class="dashboard-card">
            <div class="card-icon classes">
                <i class="fas fa-chalkboard"></i>
            </div>
            <div class="card-content">
                <div class="card-title">Classes</div>
                <div class="card-number">{{ $classes->count() }}</div>
                <div class="card-label">Associées</div>
            </div>
        </div>

        <!-- Card Heures -->
        <div class="dashboard-card">
            <div class="card-icon hours">
                <i class="fas fa-clock"></i>
            </div>
            <div class="card-content">
                <div class="card-title">Heures</div>
                <div class="card-number">{{ $courses->sum('hours') }}</div>
                <div class="card-label">Total d'heures</div>
            </div>
        </div>
    </div>

    <div class="content-grid">
        <!-- Liste des Cours Actifs -->
        <div class="content-card">
            <div class="card-header">
                <h2><i class="fas fa-book-open"></i> Cours Actifs</h2>
            </div>
            <div class="card-body">
                @if($courses->where('is_active', true)->count() > 0)
                    <div class="course-list">
                        @foreach($courses->where('is_active', true) as $course)
                            <div class="course-item">
                                <div class="course-info">
                                    <div class="course-title">{{ $course->title }}</div>
                                    <div class="course-details">
                                        <span><i class="fas fa-users"></i> {{ $course->classe->name }}</span>
                                        <span><i class="fas fa-book"></i> {{ $course->subject->name }}</span>
                                        <span><i class="fas fa-clock"></i> {{ $course->hours }}h</span>
                                    </div>
                                </div>
                                <div class="course-status {{ $course->is_active ? 'active' : 'inactive' }}">
                                    {{ $course->is_active ? 'Actif' : 'Inactif' }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state">
                        <i class="fas fa-inbox"></i>
                        <p>Aucun cours actif disponible</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Emploi du temps -->
        <div class="content-card">
            <div class="card-header">
                <h2><i class="fas fa-calendar-alt"></i> Emploi du temps</h2>
                <div class="card-header-actions">
                    <button class="btn-outline">
                        <i class="fas fa-download"></i> Exporter
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="schedule">
                    @forelse($courses->where('is_active', true)->take(5) as $course)
                        <div class="schedule-item">
                            <div class="schedule-time">
                                <i class="far fa-clock"></i>
                                <span>{{ $course->schedule ?? 'Horaire à définir' }}</span>
                            </div>
                            <div class="schedule-content">
                                <div class="schedule-title">{{ $course->title }}</div>
                                <div class="schedule-details">
                                    <span><i class="fas fa-users"></i> {{ $course->classe->name }}</span>
                                    <span><i class="fas fa-map-marker-alt"></i> {{ $course->room ?? 'Salle à définir' }}</span>
                                </div>
                            </div>
                        </div>
            @empty
                        <div class="empty-state">
                            <i class="far fa-calendar"></i>
                            <p>Aucun cours planifié</p>
                        </div>
            @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .dashboard-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .dashboard-card {
        background: white;
        border-radius: 1rem;
        padding: 1.5rem;
        display: flex;
        align-items: center;
        gap: 1.5rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        transition: transform 0.2s;
    }

    .dashboard-card:hover {
        transform: translateY(-2px);
    }

    .card-icon {
        width: 3rem;
        height: 3rem;
        border-radius: 0.75rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }

    .card-icon.courses {
        background: #EEF2FF;
        color: #4F46E5;
    }

    .card-icon.classes {
        background: #F0FDF4;
        color: #16A34A;
    }

    .card-icon.hours {
        background: #FDF2F8;
        color: #DB2777;
    }

    .card-content {
        flex: 1;
    }

    .card-title {
        font-size: 0.875rem;
        color: #6B7280;
        margin-bottom: 0.25rem;
    }

    .card-number {
        font-size: 1.875rem;
        font-weight: 600;
        color: #111827;
        line-height: 1.2;
    }

    .card-label {
        font-size: 0.875rem;
        color: #6B7280;
    }

    .content-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
        gap: 1.5rem;
    }

    .content-card {
        background: white;
        border-radius: 1rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }

    .card-header {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid #E5E7EB;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .card-header h2 {
        font-size: 1.125rem;
        font-weight: 600;
        color: #111827;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .card-body {
        padding: 1.5rem;
    }

    .course-list, .class-list {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .course-item, .class-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem;
        background: #F9FAFB;
        border-radius: 0.5rem;
        transition: background-color 0.2s;
    }

    .course-item:hover, .class-item:hover {
        background: #F3F4F6;
    }

    .course-info, .class-info {
        flex: 1;
    }

    .course-title, .class-name {
        font-weight: 500;
        color: #111827;
        margin-bottom: 0.25rem;
    }

    .course-details, .class-level {
        display: flex;
        gap: 1rem;
        color: #6B7280;
        font-size: 0.875rem;
    }

    .course-details span {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .course-status, .class-status {
        padding: 0.375rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 500;
    }

    .course-status.active, .class-status.active {
        background: #F0FDF4;
        color: #16A34A;
    }

    .course-status.inactive, .class-status.inactive {
        background: #FEF2F2;
        color: #DC2626;
    }

    .empty-state {
        text-align: center;
        padding: 3rem 1.5rem;
        color: #6B7280;
    }

    .empty-state i {
        font-size: 2.5rem;
        margin-bottom: 1rem;
    }

    .btn-outline {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        border: 1px solid #E5E7EB;
        border-radius: 0.5rem;
        color: #6B7280;
        background: transparent;
        font-size: 0.875rem;
        cursor: pointer;
        transition: all 0.2s;
    }

    .btn-outline:hover {
        border-color: #6B7280;
        color: #374151;
    }

    .course-actions {
        display: flex;
        gap: 0.5rem;
    }

    .action-btn {
        width: 2rem;
        height: 2rem;
        display: flex;
        align-items: center;
        justify-content: center;
        border: none;
        border-radius: 0.375rem;
        background: #F3F4F6;
        color: #6B7280;
        cursor: pointer;
        transition: all 0.2s;
    }

    .action-btn:hover {
        background: #E5E7EB;
        color: #374151;
    }

    .schedule {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .schedule-item {
        display: flex;
        gap: 1rem;
        padding: 1rem;
        background: #F9FAFB;
        border-radius: 0.5rem;
        transition: background-color 0.2s;
    }

    .schedule-item:hover {
        background: #F3F4F6;
    }

    .schedule-time {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.25rem;
        padding: 0.5rem;
        background: white;
        border-radius: 0.375rem;
        min-width: 5rem;
    }

    .schedule-time i {
        color: #6B7280;
    }

    .schedule-content {
        flex: 1;
    }

    .schedule-title {
        font-weight: 500;
        color: #111827;
        margin-bottom: 0.25rem;
    }

    .schedule-details {
        display: flex;
        gap: 1rem;
        color: #6B7280;
        font-size: 0.875rem;
    }

    .schedule-details span {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    @media (max-width: 768px) {
        .content-grid {
            grid-template-columns: 1fr;
        }

        .dashboard-grid {
            grid-template-columns: 1fr;
        }

        .course-details {
            flex-direction: column;
            gap: 0.5rem;
        }

        .schedule-item {
            flex-direction: column;
        }

        .schedule-time {
            flex-direction: row;
            justify-content: center;
            width: 100%;
        }
    }
</style>
@endpush
@endsection
