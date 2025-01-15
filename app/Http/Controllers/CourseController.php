<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Professor;
use App\Models\Subject;
use App\Models\Classe;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::with(['professor', 'subject', 'classe'])->get();
        return view('courses.index', compact('courses'));
    }

    public function create()
    {
        $professors = Professor::where('is_active', true)->get();
        $subjects = Subject::where('is_active', true)->get();
        $classes = Classe::where('is_active', true)->get();
        return view('courses.create', compact('professors', 'subjects', 'classes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'professor_id' => 'required|exists:professors,id',
            'subject_id' => 'required|exists:subjects,id',
            'classe_id' => 'required|exists:classes,id',
            'semester' => 'required|integer|min:1|max:2',
            'hours' => 'required|integer|min:1',
            'is_active' => 'boolean'
        ]);

        $validated['is_active'] = $request->has('is_active');

        Course::create($validated);

        return redirect()->route('courses.index')
            ->with('success', 'Cours créé avec succès.');
    }

    public function edit(Course $course)
    {
        $professors = Professor::where('is_active', true)->get();
        $subjects = Subject::where('is_active', true)->get();
        $classes = Classe::where('is_active', true)->get();
        return view('courses.edit', compact('course', 'professors', 'subjects', 'classes'));
    }

    public function update(Request $request, Course $course)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'professor_id' => 'required|exists:professors,id',
            'subject_id' => 'required|exists:subjects,id',
            'classe_id' => 'required|exists:classes,id',
            'semester' => 'required|string|max:255',
            'hours' => 'required|integer|min:1',
            'is_active' => 'boolean'
        ]);

        $course->update($validated);

        return redirect()->route('courses.index')
            ->with('success', 'Cours mis à jour avec succès.');
    }

    public function destroy(Course $course)
    {
        $course->delete();

        return redirect()->route('courses.index')
            ->with('success', 'Cours supprimé avec succès.');
    }
} 