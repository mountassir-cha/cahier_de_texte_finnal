@extends('layouts.dashboard')

@section('title', 'Gestion des Cours')

@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <div class="header-wrapper">
            <div class="header-content">
                <h1>Gestion des Cours</h1>
                <p class="text-subtitle">Gérez les cours de l'établissement</p>
            </div>
            <div class="header-actions">
                <a href="{{ route('courses.create') }}" class="btn-primary">
                    <i class="fas fa-plus"></i>
                    <span>Nouveau Cours</span>
                </a>
            </div>
        </div>
    </div>

    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th>TITRE</th>
                    <th>PROFESSEUR</th>
                    <th>MATIÈRE</th>
                    <th>CLASSE</th>
                    <th>SEMESTRE</th>
                    <th>HEURES</th>
                    <th>STATUT</th>
                    <th>ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                @forelse($courses as $course)
                    <tr>
                        <td>{{ $course->title }}</td>
                        <td>{{ $course->professor->name }}</td>
                        <td>{{ $course->subject->name }}</td>
                        <td>{{ $course->classe->name }}</td>
                        <td>{{ $course->semester }}</td>
                        <td>{{ $course->hours }}</td>
                        <td>
                            <span class="status-badge {{ $course->is_active ? 'active' : 'inactive' }}">
                                {{ $course->is_active ? 'Actif' : 'Inactif' }}
                            </span>
                        </td>
                        <td>
                            <div class="actions">
                                <a href="{{ route('courses.edit', $course->id) }}" class="btn-action edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('courses.destroy', $course->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-action delete" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce cours ?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="empty-state">Aucun cours trouvé</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@push('styles')
<style>
/* Header Styles */
.header-wrapper {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
    padding-bottom: 1.5rem;
    border-bottom: 1px solid var(--gray-200);
}

.header-content h1 {
    font-size: 2rem;
    font-weight: 700;
    color: var(--gray-900);
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.header-content h1::before {
    content: '';
    display: block;
    width: 4px;
    height: 24px;
    background: var(--primary);
    border-radius: 2px;
}

.text-subtitle {
    color: var(--gray-500);
    font-size: 1rem;
    margin-left: 1.25rem;
}

.header-actions {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.btn-primary {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: var(--primary);
    color: white;
    padding: 0.75rem 1.5rem;
    border-radius: 0.5rem;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.2s;
}

.btn-primary:hover {
    background: var(--primary-dark);
    transform: translateY(-1px);
}

/* Table Styles */
.table-container {
    background: white;
    border-radius: 1rem;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}

.table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
}

.table th {
    background: #f8fafc;
    padding: 1rem 1.5rem;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    color: var(--gray-600);
    border-bottom: 1px solid var(--gray-200);
}

.table td {
    padding: 1rem 1.5rem;
    color: var(--gray-700);
    border-bottom: 1px solid var(--gray-100);
}

.table tr:hover {
    background: #f8fafc;
}

.status-badge {
    display: inline-flex;
    align-items: center;
    padding: 0.375rem 0.75rem;
    border-radius: 9999px;
    font-size: 0.75rem;
    font-weight: 500;
}

.status-badge.active {
    background: #f0fdf4;
    color: #166534;
}

.status-badge.inactive {
    background: #fef2f2;
    color: #991b1b;
}

.actions {
    display: flex;
    gap: 0.5rem;
    justify-content: flex-end;
}

.btn-action {
    width: 2rem;
    height: 2rem;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border: none;
    border-radius: 0.375rem;
    cursor: pointer;
    transition: all 0.2s;
}

.btn-action.edit {
    background: #f0f9ff;
    color: #0369a1;
}

.btn-action.delete {
    background: #fef2f2;
    color: #991b1b;
}

.btn-action:hover {
    transform: translateY(-2px);
}

.empty-state {
    text-align: center;
    color: var(--gray-500);
    padding: 2rem;
}

@media (max-width: 768px) {
    .header-wrapper {
        flex-direction: column;
        gap: 1rem;
        align-items: flex-start;
    }

    .header-content h1 {
        font-size: 1.5rem;
    }

    .table-container {
        overflow-x: auto;
    }

    .table {
        min-width: 1000px;
    }
}
</style>
@endpush
@endsection 