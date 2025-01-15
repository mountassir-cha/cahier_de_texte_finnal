<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Classe;

class ClasseSeeder extends Seeder
{
    public function run()
    {
        $classes = [
            [
                'name' => 'Classe A',
                'level' => '1ère année',
                'capacity' => 30,
                'is_active' => true,
            ],
            [
                'name' => 'Classe B',
                'level' => '1ère année',
                'capacity' => 30,
                'is_active' => true,
            ],
            [
                'name' => 'Classe C',
                'level' => '2ème année',
                'capacity' => 25,
                'is_active' => true,
            ],
        ];

        foreach ($classes as $class) {
            Classe::create($class);
        }
    }
} 