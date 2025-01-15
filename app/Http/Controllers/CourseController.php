<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Subject;
use App\Models\Classe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::with(['professor', 'subject', 'classe'])->get();
        return view('courses.index', compact('courses'));
    }

    public function create()
    {
        $subjects = Subject::where('is_active', true)->get();
        $classes = Classe::where('is_active', true)->get();
        return view('courses.create', compact('subjects', 'classes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subject_id' => 'required|exists:subjects,id',
            'class_id' => 'required|exists:classes,id',
            'semester' => 'required|string',
            'hours' => 'required|integer|min:1',
        ]);

        // Utiliser l'ID du professeur connecté via le guard professor
        $validated['professor_id'] = Auth::guard('professor')->id();
        $validated['is_active'] = true;

        Course::create($validated);

        return redirect()->route('professor.courses.index')
            ->with('success', 'Cours créé avec succès');
    }

    public function edit(Course $course)
    {
        $subjects = Subject::where('is_active', true)->get();
        $classes = Classe::where('is_active', true)->get();
        return view('courses.edit', compact('course', 'subjects', 'classes'));
    }

    public function update(Request $request, Course $course)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subject_id' => 'required|exists:subjects,id',
            'class_id' => 'required|exists:classes,id',
            'semester' => 'required|string',
            'hours' => 'required|integer|min:1',
        ]);

        $course->update($validated);

        return redirect()->route('courses.index')
            ->with('success', 'Cours mis à jour avec succès');
    }

    public function destroy(Course $course)
    {
        $course->delete();
        return redirect()->route('courses.index')
            ->with('success', 'Cours supprimé avec succès');
    }
} 