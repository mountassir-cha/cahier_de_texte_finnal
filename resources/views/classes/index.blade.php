@extends('layouts.dashboard')

@section('title', 'Gestion des Classes')

@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <div class="header-wrapper">
            <div class="header-content">
                <h1>Gestion des Classes</h1>
                <p class="text-subtitle">Gérez les classes de l'établissement</p>
            </div>
            <div class="header-actions">
                <a href="{{ route('classes.create') }}" class="btn-primary">
                    <i class="fas fa-plus"></i>
                    <span>Nouvelle Classe</span>
                </a>
            </div>
        </div>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon classes">
                <i class="fas fa-chalkboard"></i>
            </div>
            <div class="stat-info">
                <h3>Classes Actives</h3>
                <div class="stat-details">
                    <span class="stat-number">{{ $stats['active'] }}</span>
                    <span class="stat-label">sur {{ $stats['total'] }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Niveau</th>
                    <th>Capacité</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($classes as $class)
                    <tr>
                        <td>
                            <div class="class-info">
                                <div class="class-icon">
                                    <i class="fas fa-graduation-cap"></i>
                                </div>
                                <span class="class-name">{{ $class->name }}</span>
                            </div>
                        </td>
                        <td>{{ $class->level }}</td>
                        <td>
                            <div class="capacity-info">
                                <span class="capacity-number">{{ $class->capacity }}</span>
                                <span class="capacity-label">étudiants</span>
                            </div>
                        </td>
                        <td>
                            <span class="status-badge {{ $class->is_active ? 'active' : 'inactive' }}">
                                {{ $class->is_active ? 'Actif' : 'Inactif' }}
                            </span>
                        </td>
                        <td>
                            <div class="actions">
                                <a href="{{ route('classes.edit', $class->id) }}" class="btn-action edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('classes.destroy', $class->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-action delete" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette classe ?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="empty-state">
                            <p>Aucune classe trouvée</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@push('styles')
<style>
.content-wrapper {
    padding: 2rem;
}

.page-header {
    margin-bottom: 2rem;
}

.page-header h1 {
    font-size: 1.875rem;
    font-weight: 600;
    color: #111827;
    margin-bottom: 0.5rem;
}

.text-subtitle {
    color: #6B7280;
    font-size: 0.95rem;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.stat-card {
    background: white;
    border-radius: 1rem;
    padding: 1.5rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    transition: transform 0.2s;
}

.stat-card:hover {
    transform: translateY(-2px);
}

.stat-icon {
    width: 3rem;
    height: 3rem;
    border-radius: 0.75rem;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    color: white;
}

.stat-icon.classes {
    background: #10B981;
}

.stat-info h3 {
    font-size: 0.875rem;
    color: #6B7280;
    margin-bottom: 0.25rem;
}

.stat-details {
    display: flex;
    align-items: baseline;
    gap: 0.5rem;
}

.stat-number {
    font-size: 1.5rem;
    font-weight: 600;
    color: #111827;
}

.stat-label {
    font-size: 0.875rem;
    color: #6B7280;
}

.table-container {
    background: white;
    border-radius: 1rem;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    overflow: hidden;
    margin-bottom: 2rem;
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
    letter-spacing: 0.05em;
    color: #64748b;
    text-transform: uppercase;
    border-bottom: 1px solid #e2e8f0;
}

.table td {
    padding: 1rem 1.5rem;
    color: #334155;
    border-bottom: 1px solid #f1f5f9;
}

.table tr:hover {
    background: #f8fafc;
}

.class-info {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.class-icon {
    width: 2.5rem;
    height: 2.5rem;
    background: #7c3aed;
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.class-name {
    font-weight: 500;
    color: #111827;
}

.capacity-info {
    display: flex;
    align-items: baseline;
    gap: 0.25rem;
}

.capacity-number {
    font-weight: 600;
    color: #111827;
}

.capacity-label {
    font-size: 0.875rem;
    color: #6B7280;
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
}

.btn-action {
    width: 2rem;
    height: 2rem;
    border: none;
    border-radius: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
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

.btn-action.edit:hover {
    background: #0369a1;
    color: white;
}

.btn-action.delete:hover {
    background: #991b1b;
    color: white;
}

.btn-add {
    position: fixed;
    bottom: 2rem;
    right: 2rem;
    background: #7c3aed;
    color: white;
    border: none;
    padding: 0.75rem 1.5rem;
    border-radius: 9999px;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-weight: 500;
    cursor: pointer;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1),
                0 2px 4px -1px rgba(0, 0, 0, 0.06);
    transition: all 0.3s ease;
}

.btn-add:hover {
    transform: translateY(-2px);
    background: #6d28d9;
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1),
                0 4px 6px -2px rgba(0, 0, 0, 0.05);
}

.empty-state {
    text-align: center;
    padding: 3rem;
    color: #6B7280;
}

@media (max-width: 1024px) {
    .content-wrapper {
        padding: 1rem;
    }

    .stats-grid {
        grid-template-columns: 1fr;
    }

    .table {
        min-width: 800px;
    }
}

@media (max-width: 640px) {
    .page-header h1 {
        font-size: 1.5rem;
    }

    .btn-add {
        bottom: 1rem;
        right: 1rem;
        padding: 0.5rem 1rem;
    }
}
</style>
@endpush
@endsection 