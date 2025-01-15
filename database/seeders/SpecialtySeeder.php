<?php

namespace Database\Seeders;

use App\Models\Specialty;
use Illuminate\Database\Seeder;

class SpecialtySeeder extends Seeder
{
    public function run()
    {
        $specialties = [
            ['name' => 'Informatique', 'description' => 'Sciences informatiques et programmation'],
            ['name' => 'Mathématiques', 'description' => 'Mathématiques pures et appliquées'],
            ['name' => 'Physique', 'description' => 'Physique théorique et expérimentale'],
            ['name' => 'Chimie', 'description' => 'Chimie organique et inorganique'],
            ['name' => 'Biologie', 'description' => 'Sciences biologiques'],
        ];

        foreach ($specialties as $specialty) {
            Specialty::create($specialty);
        }
    }
} 