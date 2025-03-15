<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Utilisateur;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Vérifier si l'admin existe déjà
        if (!Utilisateur::where('email', env('ADMIN_EMAIL'))->exists()) {
            Utilisateur::create([
                'nom' => env('ADMIN_NOM', 'Admin'),
                'prenom' => env('ADMIN_PRENOM', 'System'),
                'email' => env('ADMIN_EMAIL', 'admin@admin.com'),
                'password' => Hash::make(env('ADMIN_PASSWORD', 'admin123')),
                'role' => 'admin',
                'status' => 'actif',
                'date_creation' => now(),
                'created_by' => 0
            ]);
        }
    }
}
