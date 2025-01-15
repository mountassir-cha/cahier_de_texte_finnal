@extends('layouts.dashboard')

@section('title', 'Analytics')

@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <div class="header-wrapper">
            <div class="header-content">
                <h1>Analytics</h1>
                <p class="text-subtitle">Vue d'ensemble des statistiques de l'établissement</p>
            </div>
            <div class="header-actions">
                <div class="date-filter">
                    <i class="fas fa-calendar"></i>
                    <span>{{ now()->format('d M Y') }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="analytics-grid">
        <!-- Card Professeurs -->
        <div class="stats-card">
            <div class="stats-header">
                <div class="stats-icon professors">
                    <i class="fas fa-user-tie"></i>
                </div>
                <div class="stats-info">
                    <h3>Professeurs</h3>
                    <div class="stats-number">{{ $totalProfessors }}</div>
                </div>
            </div>
            <div class="stats-footer">
                <div class="stats-detail">
                    <div class="detail-item active">
                        <span class="label">Actifs</span>
                        <span class="value">{{ $activeProfessors }}</span>
                    </div>
                    <div class="detail-item inactive">
                        <span class="label">Inactifs</span>
                        <span class="value">{{ $inactiveProfessors }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card Classes -->
        <div class="stats-card">
            <div class="stats-header">
                <div class="stats-icon classes">
                    <i class="fas fa-chalkboard"></i>
                </div>
                <div class="stats-info">
                    <h3>Classes</h3>
                    <div class="stats-number">{{ $totalClasses }}</div>
                </div>
            </div>
            <div class="stats-footer">
                <div class="stats-detail">
                    <div class="detail-item active">
                        <span class="label">Actives</span>
                        <span class="value">{{ $activeClasses }}</span>
                    </div>
                    <div class="detail-item inactive">
                        <span class="label">Inactives</span>
                        <span class="value">{{ $inactiveClasses }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card Cours -->
        <div class="stats-card">
            <div class="stats-header">
                <div class="stats-icon courses">
                    <i class="fas fa-book"></i>
                </div>
                <div class="stats-info">
                    <h3>Cours</h3>
                    <div class="stats-number">{{ $totalCourses }}</div>
                </div>
            </div>
            <div class="stats-footer">
                <div class="stats-detail">
                    <div class="detail-item active">
                        <span class="label">Actifs</span>
                        <span class="value">{{ $activeCourses }}</span>
                    </div>
                    <div class="detail-item inactive">
                        <span class="label">Inactifs</span>
                        <span class="value">{{ $inactiveCourses }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card Matières -->
        <div class="stats-card">
            <div class="stats-header">
                <div class="stats-icon subjects">
                    <i class="fas fa-flask"></i>
                </div>
                <div class="stats-info">
                    <h3>Matières</h3>
                    <div class="stats-number">{{ $totalSubjects }}</div>
                </div>
            </div>
            <div class="stats-footer">
                <div class="stats-detail">
                    <div class="detail-item active">
                        <span class="label">Actives</span>
                        <span class="value">{{ $activeSubjects }}</span>
                    </div>
                    <div class="detail-item inactive">
                        <span class="label">Inactives</span>
                        <span class="value">{{ $inactiveSubjects }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="charts-grid">
        <div class="chart-card">
            <div class="chart-header">
                <h3>Distribution des Professeurs par Spécialité</h3>
                <div class="chart-actions">
                    <button class="chart-action-btn" onclick="downloadChart('professorsBySpecialty')">
                        <i class="fas fa-download"></i>
                    </button>
                </div>
            </div>
            <div class="chart-body">
                <canvas id="professorsBySpecialty"></canvas>
            </div>
        </div>

        <div class="chart-card">
            <div class="chart-header">
                <h3>Cours par Semestre</h3>
                <div class="chart-actions">
                    <button class="chart-action-btn" onclick="downloadChart('coursesBySemester')">
                        <i class="fas fa-download"></i>
                    </button>
                </div>
            </div>
            <div class="chart-body">
                <canvas id="coursesBySemester"></canvas>
            </div>
        </div>

        <div class="chart-card">
            <div class="chart-header">
                <h3>Cours par Classe</h3>
                <div class="chart-actions">
                    <button class="chart-action-btn" onclick="downloadChart('coursesByClass')">
                        <i class="fas fa-download"></i>
                    </button>
                </div>
            </div>
            <div class="chart-body">
                <canvas id="coursesByClass"></canvas>
            </div>
        </div>
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

.date-filter {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.75rem 1.5rem;
    background: white;
    border-radius: 1rem;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    color: var(--gray-700);
    font-size: 0.875rem;
    font-weight: 500;
}

.date-filter i {
    color: var(--primary);
}

/* Your existing analytics styles */
.analytics-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.stats-card {
    background: white;
    border-radius: 1rem;
    padding: 1.5rem;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    transition: transform 0.2s;
}

.stats-card:hover {
    transform: translateY(-4px);
}

.stats-header {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1.5rem;
}

.stats-icon {
    width: 3rem;
    height: 3rem;
    border-radius: 0.75rem;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
}

.stats-icon i {
    font-size: 1.25rem;
}

.stats-icon.professors { background: linear-gradient(135deg, #6366F1, #4F46E5); }
.stats-icon.classes { background: linear-gradient(135deg, #F59E0B, #D97706); }
.stats-icon.courses { background: linear-gradient(135deg, #10B981, #059669); }
.stats-icon.subjects { background: linear-gradient(135deg, #3B82F6, #2563EB); }

.stats-info h3 {
    margin: 0;
    font-size: 0.875rem;
    color: #6B7280;
    font-weight: 500;
}

.stats-number {
    font-size: 1.875rem;
    font-weight: 600;
    color: #111827;
    line-height: 1.2;
}

.stats-footer {
    border-top: 1px solid #E5E7EB;
    padding-top: 1rem;
    margin-top: 1rem;
}

.stats-detail {
    display: flex;
    justify-content: space-between;
}

.detail-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.25rem;
}

.detail-item .label {
    font-size: 0.75rem;
    color: #6B7280;
}

.detail-item .value {
    font-weight: 600;
    color: #374151;
}

.detail-item.active .value { color: #059669; }
.detail-item.inactive .value { color: #DC2626; }

.charts-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
    gap: 1.5rem;
    margin-top: 2rem;
}

.chart-card {
    background: white;
    border-radius: 1rem;
    padding: 1.5rem;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
}

.chart-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
}

.chart-header h3 {
    margin: 0;
    font-size: 1.1rem;
    color: #374151;
    font-weight: 600;
}

.chart-actions {
    display: flex;
    gap: 0.5rem;
}

.chart-action-btn {
    background: #F3F4F6;
    border: none;
    padding: 0.5rem;
    border-radius: 0.5rem;
    cursor: pointer;
    color: #4B5563;
    transition: all 0.2s;
}

.chart-action-btn:hover {
    background: #E5E7EB;
    color: #1F2937;
}

.chart-body {
    position: relative;
    height: 300px;
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

    .date-filter {
        width: 100%;
        justify-content: center;
    }

    .analytics-grid {
        grid-template-columns: 1fr;
    }

    .charts-grid {
        grid-template-columns: 1fr;
    }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Configuration des graphiques (garder le code existant)
    // ...

    // Fonction pour télécharger les graphiques
    window.downloadChart = function(chartId) {
        const canvas = document.getElementById(chartId);
        const link = document.createElement('a');
        link.download = `${chartId}.png`;
        link.href = canvas.toDataURL('image/png');
        link.click();
    };
});
</script>
@endpush
@endsection 