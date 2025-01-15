<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Professor;
use App\Models\Course;
use App\Models\Classe;
use App\Models\Subject;
use Illuminate\Support\Facades\DB;

class ProfessorSeeder extends Seeder
{
    public function run()
    {
        // Nettoyer les données existantes
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Professor::truncate();
        Course::truncate();
        Classe::truncate();
        Subject::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Create a professor
        $professor = Professor::create([
            'name' => 'John Doe',
            'email' => 'prof@example.com',
            'password' => bcrypt('password'),
            'is_active' => true,
        ]);

        // Create some classes with capacity
        $classes = [
            [
                'name' => 'Classe A', 
                'level' => '1ère année', 
                'capacity' => 30,
                'is_active' => true
            ],
            [
                'name' => 'Classe B', 
                'level' => '2ème année', 
                'capacity' => 25,
                'is_active' => true
            ],
            [
                'name' => 'Classe C', 
                'level' => '3ème année', 
                'capacity' => 20,
                'is_active' => true
            ],
        ];

        foreach ($classes as $class) {
            Classe::create($class);
        }

        // Create subjects with all required fields
        $subjects = [
            [
                'name' => 'Mathématiques',
                'code' => 'MATH101',
                'description' => 'Cours de mathématiques fondamentales',
                'credits' => 6,
                'is_active' => true
            ],
            [
                'name' => 'Physique',
                'code' => 'PHY101',
                'description' => 'Cours de physique générale',
                'credits' => 5,
                'is_active' => true
            ],
            [
                'name' => 'Informatique',
                'code' => 'INFO101',
                'description' => 'Introduction à la programmation',
                'credits' => 4,
                'is_active' => true
            ],
            [
                'name' => 'Chimie',
                'code' => 'CHEM101',
                'description' => 'Chimie générale',
                'credits' => 4,
                'is_active' => true
            ],
            [
                'name' => 'Biologie',
                'code' => 'BIO101',
                'description' => 'Sciences biologiques',
                'credits' => 4,
                'is_active' => true
            ],
            [
                'name' => 'Anglais',
                'code' => 'ENG101',
                'description' => 'Anglais technique',
                'credits' => 2,
                'is_active' => true
            ]
        ];

        $createdSubjects = [];
        foreach ($subjects as $subject) {
            $createdSubjects[] = Subject::create($subject);
        }

        // Create courses for the professor
        $courses = [
            [
                'title' => 'Algèbre linéaire',
                'professor_id' => $professor->id,
                'subject_id' => $createdSubjects[0]->id,
                'class_id' => 1,
                'semester' => 'S1',
                'hours' => 30,
                'is_active' => true,
            ],
            [
                'title' => 'Mécanique quantique',
                'professor_id' => $professor->id,
                'subject_id' => $createdSubjects[1]->id,
                'class_id' => 2,
                'semester' => 'S1',
                'hours' => 24,
                'is_active' => true,
            ],
            [
                'title' => 'Programmation orientée objet',
                'professor_id' => $professor->id,
                'subject_id' => $createdSubjects[2]->id,
                'class_id' => 3,
                'semester' => 'S2',
                'hours' => 36,
                'is_active' => true,
            ],
            [
                'title' => 'Chimie organique',
                'professor_id' => $professor->id,
                'subject_id' => $createdSubjects[3]->id,
                'class_id' => 1,
                'semester' => 'S2',
                'hours' => 28,
                'is_active' => true,
            ]
        ];

        foreach ($courses as $course) {
            Course::create($course);
        }
    }
} 