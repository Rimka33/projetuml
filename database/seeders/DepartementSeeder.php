<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Departement;
use Illuminate\Support\Facades\DB;

class DepartementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('departements')->insert([
            [
                'nom' => 'Génie Informatique',
                'code' => 'GI',
                'description' => 'Département de Génie Informatique',
                'status' => 'actif',
                'date_creation' => now(),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nom' => 'Génie Électrique',
                'code' => 'GE',
                'description' => 'Département de Génie Électrique',
                'status' => 'actif',
                'date_creation' => now(),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nom' => 'Génie Mécanique',
                'code' => 'GM',
                'description' => 'Département de Génie Mécanique',
                'status' => 'actif',
                'date_creation' => now(),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nom' => 'Génie Civil',
                'code' => 'GC',
                'description' => 'Département de Génie Civil',
                'status' => 'actif',
                'date_creation' => now(),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nom' => 'Gestion',
                'code' => 'GEST',
                'description' => 'Département de Gestion',
                'status' => 'actif',
                'date_creation' => now(),
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
