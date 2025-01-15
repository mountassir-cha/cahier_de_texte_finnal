<?php

namespace App\Http\Controllers;

use App\Models\Professor;
use App\Models\Course;
use App\Models\Classe;
use App\Models\Subject;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'professors' => Professor::where('is_active', true)->count(),
            'courses' => Course::count(),
            'classes' => Classe::where('is_active', true)->count(),
            'subjects' => Subject::count()
        ];

        return view('dashboard.index', compact('stats'));
    }

    public function profile()
    {
        return view('dashboard.profile');
    }

    public function analytics()
    {
        return view('dashboard.analytics');
    }

    public function settings()
    {
        return view('dashboard.settings');
    }
} 