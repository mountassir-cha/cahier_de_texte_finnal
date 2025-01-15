<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Professor;
use App\Models\Course;
use App\Models\Classe;
use App\Models\CahierTexte;
use App\Models\Subject;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ProfessorController extends Controller
{
    use AuthorizesRequests;

    public function showLoginForm()
    {
        if (Auth::guard('professor')->check()) {
            return redirect()->route('professor.dashboard');
        }
        
        return view('professors.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('professor')->check()) {
            return redirect()->route('professor.dashboard');
        }

        if (Auth::guard('professor')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended(route('professor.dashboard'));
        }

        return back()->withErrors([
            'email' => 'Les identifiants fournis ne correspondent pas à nos enregistrements.',
        ])->withInput($request->only('email'));
    }

    public function dashboard()
    {
        $professor = Auth::guard('professor')->user();
        
        // Get courses associated with the professor
        $courses = Course::where('professor_id', $professor->id)
            ->with(['classe', 'subject']) // Eager load relationships
            ->get();
        
        // Get classes through courses
        $classes = Classe::whereIn('id', $courses->pluck('class_id'))->get();

        // Get total hours
        $totalHours = $courses->sum('hours');

        // Group courses by semester
        $coursesBySemester = $courses->groupBy('semester');

        return view('professors.dashboard', compact('courses', 'classes', 'totalHours', 'coursesBySemester'));
    }

    public function logout()
    {
        Auth::guard('professor')->logout();
        return redirect()->route('professor.login');
    }

    public function index()
    {
        $professors = Professor::all();
        return view('professors.index', compact('professors'));
    }

    public function showCahierTexte(Request $request)
    {
        $professor = Auth::guard('professor')->user();
        
        $courses = Course::where('professor_id', $professor->id)
            ->with(['classe', 'subject'])
            ->get();

        $content = '';
        $selectedDate = null;
        $selectedCourseId = $request->course_id;

        // Récupérer les derniers cahiers de texte
        $cahierTextes = CahierTexte::where('professor_id', $professor->id)
            ->with(['course.classe', 'course.subject'])
            ->orderBy('date', 'desc')
            ->take(10)
            ->get();

        if ($selectedCourseId) {
            $cahierTexte = CahierTexte::where('professor_id', $professor->id)
                ->where('course_id', $selectedCourseId)
                ->latest()
                ->first();

            if ($cahierTexte) {
                $content = $cahierTexte->content;
                $selectedDate = $cahierTexte->date;
            }
        }

        return view('professors.cahier-texte', compact(
            'courses', 
            'content', 
            'selectedDate', 
            'selectedCourseId',
            'cahierTextes'
        ));
    }

    public function updateCahierTexte(Request $request)
    {
        try {
            $validated = $request->validate([
                'course_id' => 'required|exists:courses,id',
                'content' => 'required|string',
                'date' => 'required|date',
            ]);

            $professor = Auth::guard('professor')->id();
            
            // Vérifier si le professeur a accès à ce cours
            $course = Course::where('id', $validated['course_id'])
                ->where('professor_id', $professor)
                ->firstOrFail();

            $cahierTexte = CahierTexte::updateOrCreate(
                [
                    'professor_id' => $professor,
                    'course_id' => $validated['course_id'],
                    'date' => $validated['date'],
                ],
                [
                    'content' => $validated['content'],
                ]
            );

            $cahierTexte->load(['course.classe', 'course.subject']);

            return response()->json([
                'success' => true,
                'message' => 'Cahier de texte mis à jour avec succès',
                'data' => [
                    'id' => $cahierTexte->id,
                    'date' => $cahierTexte->date->format('Y-m-d'),
                    'content' => $cahierTexte->content,
                    'course' => [
                        'id' => $cahierTexte->course->id,
                        'title' => $cahierTexte->course->title,
                        'classe' => [
                            'name' => $cahierTexte->course->classe->name
                        ],
                        'subject' => [
                            'name' => $cahierTexte->course->subject->name
                        ]
                    ]
                ]
            ]);
        } catch (\Exception $e) {
            \Log::error('Erreur cahier de texte: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la mise à jour: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getCahierTexteContent(Request $request)
    {
        try {
            $professor = Auth::guard('professor')->id();
            
            $cahierTexte = CahierTexte::where('professor_id', $professor)
                ->where('course_id', $request->course_id)
                ->where('date', $request->date)
                ->first();

            return response()->json([
                'success' => true,
                'content' => $cahierTexte ? $cahierTexte->content : '',
                'date' => $cahierTexte ? $cahierTexte->date->format('Y-m-d') : null,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors du chargement: ' . $e->getMessage()
            ], 500);
        }
    }

    public function courses()
    {
        $professor = Auth::guard('professor')->user();
        $courses = Course::where('professor_id', $professor->id)
            ->with(['classe', 'subject'])
            ->get();

        return view('professors.courses.index', compact('courses'));
    }

    public function createCourse()
    {
        $subjects = Subject::where('is_active', true)->get();
        $classes = Classe::where('is_active', true)->get();

        return view('professors.courses.create', compact('subjects', 'classes'));
    }

    public function storeCourse(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subject_id' => 'required|exists:subjects,id',
            'class_id' => 'required|exists:classes,id',
            'semester' => 'required|string',
            'hours' => 'required|integer|min:1',
        ]);

        $validated['professor_id'] = Auth::guard('professor')->id();
        $validated['is_active'] = true;

        Course::create($validated);

        return redirect()->route('professor.courses.index')
            ->with('success', 'Cours créé avec succès');
    }

    public function editCourse(Course $course)
    {
        $this->authorize('update', $course);
        
        $subjects = Subject::where('is_active', true)->get();
        $classes = Classe::where('is_active', true)->get();

        return view('professors.courses.edit', compact('course', 'subjects', 'classes'));
    }

    public function updateCourse(Request $request, Course $course)
    {
        $this->authorize('update', $course);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subject_id' => 'required|exists:subjects,id',
            'class_id' => 'required|exists:classes,id',
            'semester' => 'required|string',
            'hours' => 'required|integer|min:1',
        ]);

        $course->update($validated);

        return redirect()->route('professor.courses.index')
            ->with('success', 'Cours mis à jour avec succès');
    }

    public function deleteCourse(Course $course)
    {
        $this->authorize('delete', $course);

        $course->delete();

        return redirect()->route('professor.courses.index')
            ->with('success', 'Cours supprimé avec succès');
    }
} 