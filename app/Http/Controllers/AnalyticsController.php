<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Professor;
use App\Models\Student;
use App\Models\Classe;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    public function index()
    {
        // Get courses per semester
        $coursesPerSemester = Course::select('semester', DB::raw('count(*) as total'))
            ->groupBy('semester')
            ->get()
            ->pluck('total', 'semester')
            ->toArray();

        // Get courses per subject
        $coursesPerSubject = Course::select('subjects.name', DB::raw('count(*) as total'))
            ->join('subjects', 'courses.subject_id', '=', 'subjects.id')
            ->groupBy('subjects.name')
            ->get()
            ->pluck('total', 'name')
            ->toArray();

        // Get active vs inactive courses
        $courseStatus = [
            'active' => Course::where('is_active', true)->count(),
            'inactive' => Course::where('is_active', false)->count()
        ];

        // Get classes distribution
        $classesDistribution = Classe::select('level', DB::raw('count(*) as total'))
            ->groupBy('level')
            ->get()
            ->pluck('total', 'level')
            ->toArray();

        // Get professors per subject
        $professorsPerSubject = Course::select('subjects.name', DB::raw('COUNT(DISTINCT courses.professor_id) as total'))
            ->join('subjects', 'courses.subject_id', '=', 'subjects.id')
            ->groupBy('subjects.name')
            ->get()
            ->pluck('total', 'name')
            ->toArray();

        // Get hours per subject
        $hoursPerSubject = Course::select('subjects.name', DB::raw('SUM(courses.hours) as total'))
            ->join('subjects', 'courses.subject_id', '=', 'subjects.id')
            ->groupBy('subjects.name')
            ->get()
            ->pluck('total', 'name')
            ->toArray();

        return view('analytics.index', compact(
            'coursesPerSemester',
            'coursesPerSubject',
            'courseStatus',
            'classesDistribution',
            'professorsPerSubject',
            'hoursPerSubject'
        ));
    }
} 