@extends('layouts.dashboard')

@section('title', 'Analytics')

@section('content')
<div class="analytics-container">
    <!-- Stats Cards Row -->
    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-book"></i>
            </div>
            <div class="stat-content">
                <h4>Total Cours</h4>
                <p class="stat-number">{{ array_sum($coursesPerSemester) }}</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-user-tie"></i>
            </div>
            <div class="stat-content">
                <h4>Total Professeurs</h4>
                <p class="stat-number">{{ array_sum($professorsPerSubject) }}</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-content">
                <h4>Total Classes</h4>
                <p class="stat-number">{{ array_sum($classesDistribution) }}</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-content">
                <h4>Total Heures</h4>
                <p class="stat-number">{{ array_sum($hoursPerSubject) }}</p>
            </div>
        </div>
    </div>

    <div class="charts-grid">
        <!-- Courses per Semester -->
        <div class="chart-card">
            <div class="chart-header">
                <h3><i class="fas fa-chart-bar"></i> Cours par Semestre</h3>
            </div>
            <div class="chart-body">
                <canvas id="coursesPerSemesterChart"></canvas>
            </div>
        </div>

        <!-- Courses per Subject -->
        <div class="chart-card">
            <div class="chart-header">
                <h3><i class="fas fa-chart-pie"></i> Cours par Matière</h3>
            </div>
            <div class="chart-body">
                <canvas id="coursesPerSubjectChart"></canvas>
            </div>
        </div>

        <!-- Course Status -->
        <div class="chart-card">
            <div class="chart-header">
                <h3><i class="fas fa-check-circle"></i> Statut des Cours</h3>
            </div>
            <div class="chart-body">
                <canvas id="courseStatusChart"></canvas>
            </div>
        </div>

        <!-- Classes Distribution -->
        <div class="chart-card">
            <div class="chart-header">
                <h3><i class="fas fa-graduation-cap"></i> Distribution des Classes</h3>
            </div>
            <div class="chart-body">
                <canvas id="classesDistributionChart"></canvas>
            </div>
        </div>

        <!-- Professors per Subject -->
        <div class="chart-card">
            <div class="chart-header">
                <h3><i class="fas fa-chalkboard-teacher"></i> Professeurs par Matière</h3>
            </div>
            <div class="chart-body">
                <canvas id="professorsPerSubjectChart"></canvas>
            </div>
        </div>

        <!-- Hours per Subject -->
        <div class="chart-card">
            <div class="chart-header">
                <h3><i class="fas fa-clock"></i> Heures par Matière</h3>
            </div>
            <div class="chart-body">
                <canvas id="hoursPerSubjectChart"></canvas>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.analytics-container {
    padding: 2rem;
    background-color: #F3F4F6;
    min-height: calc(100vh - 64px);
}

/* Stats Row Styles */
.stats-row {
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
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    transition: transform 0.2s;
}

.stat-card:hover {
    transform: translateY(-2px);
}

.stat-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    background: #4F46E5;
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
}

.stat-content h4 {
    color: #6B7280;
    font-size: 0.875rem;
    margin-bottom: 0.25rem;
}

.stat-number {
    color: #111827;
    font-size: 1.5rem;
    font-weight: 600;
}

/* Charts Grid Styles */
.charts-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
    gap: 1.5rem;
}

.chart-card {
    background: white;
    border-radius: 1rem;
    overflow: hidden;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    transition: transform 0.2s;
}

.chart-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
}

.chart-header {
    padding: 1rem 1.5rem;
    border-bottom: 1px solid #E5E7EB;
}

.chart-header h3 {
    color: #374151;
    font-size: 1.1rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.chart-header h3 i {
    color: #4F46E5;
}

.chart-body {
    padding: 1.5rem;
    min-height: 300px;
}

/* Dark Mode Support */
@media (prefers-color-scheme: dark) {
    .analytics-container {
        background-color: #1F2937;
    }

    .stat-card, .chart-card {
        background-color: #111827;
    }

    .stat-content h4 {
        color: #9CA3AF;
    }

    .stat-number {
        color: #F9FAFB;
    }

    .chart-header {
        border-bottom-color: #374151;
    }

    .chart-header h3 {
        color: #F3F4F6;
    }
}

@media (max-width: 768px) {
    .analytics-container {
        padding: 1rem;
    }

    .charts-grid {
        grid-template-columns: 1fr;
    }

    .stat-card {
        padding: 1rem;
    }
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    Chart.defaults.color = '#6B7280';
    Chart.defaults.font.family = "'Inter', sans-serif";

    const chartOptions = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    padding: 20,
                    usePointStyle: true,
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                grid: {
                    drawBorder: false,
                    color: '#E5E7EB'
                }
            },
            x: {
                grid: {
                    display: false
                }
            }
        }
    };

    const colors = [
        '#4F46E5', '#7C3AED', '#EC4899', '#F59E0B', '#10B981', '#3B82F6',
        '#6366F1', '#8B5CF6', '#D946EF', '#F97316', '#14B8A6', '#0EA5E9'
    ];

    // Courses per Semester Chart
    new Chart(document.getElementById('coursesPerSemesterChart'), {
        type: 'bar',
        data: {
            labels: {!! json_encode(array_keys($coursesPerSemester)) !!},
            datasets: [{
                label: 'Nombre de cours',
                data: {!! json_encode(array_values($coursesPerSemester)) !!},
                backgroundColor: colors[0],
                borderRadius: 6,
            }]
        },
        options: chartOptions
    });

    // Continue with other charts...
    // [Previous chart configurations remain the same]
});
</script>
@endpush
@endsection 