@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <div class="header-wrapper">
            <div class="header-content">
                <h1>Dashboard</h1>
                <p class="text-subtitle">Vue d'ensemble de l'établissement</p>
            </div>
            <div class="header-actions">
                <div class="date-filter">
                    <i class="fas fa-calendar"></i>
                    <span>{{ now()->format('d M Y') }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon professors">
                <i class="fas fa-user-tie"></i>
            </div>
            <div class="stat-info">
                <h3>Professeurs</h3>
                <div class="stat-details">
                    <span class="stat-number">{{ $stats['professors'] }}</span>
                    <span class="stat-label">Actifs</span>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon courses">
                <i class="fas fa-graduation-cap"></i>
            </div>
            <div class="stat-info">
                <h3>Cours</h3>
                <div class="stat-details">
                    <span class="stat-number">{{ $stats['courses'] }}</span>
                    <span class="stat-label">En cours</span>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon classes">
                <i class="fas fa-chalkboard"></i>
            </div>
            <div class="stat-info">
                <h3>Classes</h3>
                <div class="stat-details">
                    <span class="stat-number">{{ $stats['classes'] }}</span>
                    <span class="stat-label">Actives</span>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon subjects">
                <i class="fas fa-book"></i>
            </div>
            <div class="stat-info">
                <h3>Matières</h3>
                <div class="stat-details">
                    <span class="stat-number">{{ $stats['subjects'] }}</span>
                    <span class="stat-label">Ce semestre</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 