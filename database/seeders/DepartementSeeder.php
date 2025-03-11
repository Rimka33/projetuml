<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Departement;

class DepartementSeeder extends Seeder
{
    public function run(): void
    {
        $departements = [
            [
                'nom' => 'Département Informatique',
                'description' => 'Département des Sciences Informatiques',
                'status' => 'actif',
                'date_creation' => now(),
            ],
            [
                'nom' => 'Département Mathématiques',
                'description' => 'Département des Sciences Mathématiques',
                'status' => 'actif',
                'date_creation' => now(),
            ],
            [
                'nom' => 'Département Physique',
                'description' => 'Département des Sciences Physiques',
                'status' => 'actif',
                'date_creation' => now(),
            ]
        ];

        foreach ($departements as $departement) {
            Departement::create($departement);
        }
    }
}
