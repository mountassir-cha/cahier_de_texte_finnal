<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    public function index()
    {
        $classes = Classe::all();
        $stats = [
            'total' => $classes->count(),
            'active' => $classes->where('is_active', true)->count()
        ];
        
        return view('classes.index', compact('classes', 'stats'));
    }

    public function create()
    {
        return view('classes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'level' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
            'is_active' => 'boolean'
        ]);

        $validated['is_active'] = $request->has('is_active');

        Classe::create($validated);

        return redirect()->route('classes.index')
            ->with('success', 'Classe créée avec succès.');
    }

    public function edit($id)
    {
        $class = Classe::findOrFail($id);
        return view('classes.edit', compact('class'));
    }

    public function update(Request $request, $id)
    {
        $class = Classe::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'level' => 'required|string',
            'capacity' => 'required|integer|min:1',
            'is_active' => 'boolean'
        ]);

        $class->update($validated);

        return redirect()->route('classes.index')
            ->with('success', 'Classe modifiée avec succès');
    }

    public function destroy($id)
    {
        $class = Classe::findOrFail($id);
        $class->delete();

        return redirect()->route('classes.index')
            ->with('success', 'Classe supprimée avec succès');
    }
} 