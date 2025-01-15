<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\Professor;
use App\Models\Subject;
use App\Models\Classe;

class CourseSeeder extends Seeder
{
    public function run()
    {
        $professor = Professor::first();
        $subjects = Subject::all();
        $classes = Classe::all();

        foreach ($subjects as $subject) {
            foreach ($classes as $class) {
                Course::create([
                    'title' => "Cours de {$subject->name}",
                    'professor_id' => $professor->id,
                    'subject_id' => $subject->id,
                    'class_id' => $class->id,
                    'semester' => 'S1',
                    'hours' => 30,
                    'is_active' => true,
                ]);
            }
        }
    }
} 