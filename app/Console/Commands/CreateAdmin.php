<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Utilisateur;
use Illuminate\Support\Facades\Hash;

class CreateAdmin extends Command
{
    protected $signature = 'create:admin';
    protected $description = 'Crée un administrateur général de manière interactive';

    public function handle()
    {
        $this->info('Création d\'un nouvel administrateur');
        $this->line('----------------------------------');

        $nom = $this->ask('Nom de l\'administrateur');
        $prenom = $this->ask('Prénom de l\'administrateur');
        $email = $this->ask('Email de l\'administrateur');
        $password = $this->secret('Mot de passe');
        $confirmPassword = $this->secret('Confirmez le mot de passe');

        if ($password !== $confirmPassword) {
            $this->error('Les mots de passe ne correspondent pas !');
            return 1;
        }

        // Vérifier si l'utilisateur existe déjà
        $existingUser = Utilisateur::where('email', $email)->first();
        if ($existingUser) {
            $this->error("Un utilisateur avec cet email existe déjà !");
            return 1;
        }

        // Créer l'administrateur
        $admin = Utilisateur::create([
            'nom' => $nom,
            'prenom' => $prenom,
            'email' => $email,
            'password' => Hash::make($password),
            'role' => 'admin',
            'status' => 'actif',
            'date_creation' => now(),
            'created_by' => 0 // 0 pour indiquer que c'est le premier utilisateur
        ]);

        $this->info("Administrateur créé avec succès !");
        $this->table(
            ['ID', 'Nom', 'Prénom', 'Email', 'Rôle', 'Status'],
            [[$admin->id, $admin->nom, $admin->prenom, $admin->email, $admin->role, $admin->status]]
        );

        return 0;
    }
}
