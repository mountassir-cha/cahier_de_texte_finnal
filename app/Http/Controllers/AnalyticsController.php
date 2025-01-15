<?php

namespace App\Http\Controllers;

use App\Models\Professor;
use App\Models\Classe;
use App\Models\Course;
use App\Models\Subject;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    public function index()
    {
        // Statistiques de base
        $stats = [
            'professors' => [
                'total' => Professor::count(),
                'active' => Professor::where('is_active', true)->count()
            ],
            'classes' => [
                'total' => Classe::count(),
                'active' => Classe::where('is_active', true)->count()
            ],
            'courses' => [
                'total' => Course::count(),
                'active' => Course::where('is_active', true)->count()
            ],
            'subjects' => [
                'total' => Subject::count(),
                'active' => Subject::where('is_active', true)->count()
            ]
        ];

        // Calcul des inactifs
        foreach ($stats as &$stat) {
            $stat['inactive'] = $stat['total'] - $stat['active'];
        }

        // Données pour les graphiques
        $professors = Professor::all();
        $specialtyStats = $professors->groupBy('specialty')
            ->map(function ($group) {
                return $group->count();
            });

        $courses = Course::with(['classe', 'professor', 'subject'])->get();
        $semesterStats = $courses->groupBy('semester')
            ->map(function ($group) {
                return $group->count();
            })
            ->sortKeys();

        $classStats = $courses->groupBy('classe.name')
            ->map(function ($group) {
                return $group->count();
            });

        return view('analytics.index', [
            'totalProfessors' => $stats['professors']['total'],
            'activeProfessors' => $stats['professors']['active'],
            'inactiveProfessors' => $stats['professors']['inactive'],
            'totalClasses' => $stats['classes']['total'],
            'activeClasses' => $stats['classes']['active'],
            'inactiveClasses' => $stats['classes']['inactive'],
            'totalCourses' => $stats['courses']['total'],
            'activeCourses' => $stats['courses']['active'],
            'inactiveCourses' => $stats['courses']['inactive'],
            'totalSubjects' => $stats['subjects']['total'],
            'activeSubjects' => $stats['subjects']['active'],
            'inactiveSubjects' => $stats['subjects']['inactive'],
            'specialtyLabels' => $specialtyStats->keys(),
            'specialtyData' => $specialtyStats->values(),
            'specialtyColors' => [
                '#4F46E5', '#7C3AED', '#EC4899', '#8B5CF6',
                '#6366F1', '#14B8A6', '#F59E0B', '#EF4444'
            ],
            'semesterLabels' => $semesterStats->keys()->map(function($sem) {
                return "Semestre $sem";
            }),
            'semesterData' => $semesterStats->values(),
            'classLabels' => $classStats->keys(),
            'classData' => $classStats->values()
        ]);
    }
} 