<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ChefDepartement;
use App\Models\Directeur;
use App\Models\Utilisateur;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\Departement;

class AdminController extends Controller
{
    public function dashboard()
    {
        $utilisateurs = Utilisateur::whereIn('role', ['chef_departement', 'directeur'])
            ->orderBy('created_at', 'desc')
            ->get();
        return view('admin.dashboard', compact('utilisateurs'));
    }

    public function createUser()
    {
        $departements = Departement::where('status', 'actif')->get();
        return view('admin.create-user', compact('departements'));
    }

    public function storeUser(Request $request)
    {
        $rules = [
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:utilisateurs',
            'role' => 'required|in:chef_departement,directeur',
            'password' => 'nullable|string|min:8',
        ];

        // Ajouter la validation du département uniquement pour les chefs de département
        if ($request->role === 'chef_departement') {
            $rules['departement_id'] = 'required|exists:departements,id';
        }

        $request->validate($rules);

        DB::beginTransaction();
        try {
            // Créer l'utilisateur de base
            $utilisateur = new Utilisateur();
            $utilisateur->nom = $request->nom;
            $utilisateur->prenom = $request->prenom;
            $utilisateur->email = $request->email;
            $utilisateur->role = $request->role;
            $utilisateur->status = 'actif';
            $utilisateur->date_creation = now();
            $utilisateur->created_by = auth()->id() ?? 1; // ID de l'admin connecté ou 1 par défaut

            // Générer un mot de passe si non fourni
            $password = $request->password ?? Str::random(10);
            $utilisateur->password = Hash::make($password);

            $utilisateur->save();

            // Créer l'entrée spécifique selon le rôle
            if ($request->role === 'chef_departement') {
                $chef = new ChefDepartement();
                $chef->utilisateur_id = $utilisateur->id;
                $chef->departement_id = $request->departement_id;
                $chef->status = 'actif';
                $chef->save();
            } elseif ($request->role === 'directeur') {
                $directeur = new Directeur();
                $directeur->utilisateur_id = $utilisateur->id;
                $directeur->status = 'actif';
                $directeur->save();
            }

            DB::commit();

            // Si le mot de passe a été généré automatiquement, afficher le mot de passe
            if (!$request->password) {
                return redirect()->route('admin.dashboard')
                    ->with('success', 'Utilisateur créé avec succès. Mot de passe temporaire : ' . $password);
            }

            return redirect()->route('admin.dashboard')
                ->with('success', 'Utilisateur créé avec succès');
        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Erreur lors de la création de l\'utilisateur : ' . $e->getMessage());
            return back()->withInput()
                ->with('error', 'Une erreur est survenue lors de la création de l\'utilisateur : ' . $e->getMessage());
        }
    }

    public function editUser($id)
    {
        $utilisateur = Utilisateur::findOrFail($id);
        return view('admin.edit-user', compact('utilisateur'));
    }

    public function updateUser(Request $request, $id)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:utilisateurs,email,'.$id,
            'status' => 'required|in:actif,inactif',
        ]);

        $utilisateur = Utilisateur::findOrFail($id);
        $utilisateur->update($request->all());

        return redirect()->route('admin.dashboard')
            ->with('success', 'Utilisateur mis à jour avec succès');
    }

    public function deleteUser($id)
    {
        $utilisateur = Utilisateur::findOrFail($id);
        $utilisateur->status = 'inactif';
        $utilisateur->save();

        return redirect()->route('admin.dashboard')
            ->with('success', 'Utilisateur désactivé avec succès');
    }
}
