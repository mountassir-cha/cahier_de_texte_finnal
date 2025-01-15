<?php

namespace Database\Seeders;

use App\Models\Classe;
use Illuminate\Database\Seeder;

class ClassSeeder extends Seeder
{
    public function run()
    {
        $classes = [
            [
                'name' => '1ère Année A',
                'level' => '1ère année',
                'description' => 'Classe de première année, groupe A',
                'is_active' => true,
            ],
            [
                'name' => '1ère Année B',
                'level' => '1ère année',
                'description' => 'Classe de première année, groupe B',
                'is_active' => true,
            ],
            [
                'name' => '2ème Année A',
                'level' => '2ème année',
                'description' => 'Classe de deuxième année, groupe A',
                'is_active' => true,
            ],
            [
                'name' => '2ème Année B',
                'level' => '2ème année',
                'description' => 'Classe de deuxième année, groupe B',
                'is_active' => true,
            ],
            [
                'name' => '3ème Année A',
                'level' => '3ème année',
                'description' => 'Classe de troisième année, groupe A',
                'is_active' => true,
            ],
        ];

        foreach ($classes as $class) {
            Classe::create($class);
        }
    }
} 