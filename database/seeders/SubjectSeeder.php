<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Subject;

class SubjectSeeder extends Seeder
{
    public function run()
    {
        $subjects = [
            [
                'name' => 'Mathématiques',
                'code' => 'MATH101',
                'description' => 'Cours de mathématiques fondamentales',
                'credits' => 6,
                'is_active' => true,
            ],
            [
                'name' => 'Physique',
                'code' => 'PHY101',
                'description' => 'Introduction à la physique',
                'credits' => 5,
                'is_active' => true,
            ],
            [
                'name' => 'Informatique',
                'code' => 'INFO101',
                'description' => 'Bases de la programmation',
                'credits' => 4,
                'is_active' => true,
            ],
        ];

        foreach ($subjects as $subject) {
            Subject::create($subject);
        }
    }
} 