<?php

namespace App\Http\Controllers;

use App\Models\Professeur;
use App\Models\Utilisateur;
use App\Models\BesoinBudgetaire;
use App\Models\ChefDepartement;
use App\Models\Departement;
use App\Models\ResponsableFinancier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ChefDepartementController extends Controller
{
    public function dashboard()
    {
        try {
            $chefDepartement = ChefDepartement::where('utilisateur_id', auth()->id())->first();

            if (!$chefDepartement) {
                return redirect()->route('dashboard')
                    ->with('error', 'Erreur : Chef de département non trouvé.');
            }

            // Récupérer les professeurs du département
            $professeurs = Professeur::where('departement_id', $chefDepartement->departement_id)
                ->with('utilisateur')
                ->get();

            // Récupérer les besoins du département qui ont été validés par le responsable financier
            $besoinsAValider = BesoinBudgetaire::where('departement_id', $chefDepartement->departement_id)
                ->where('status', 'approved_by_rf')
                ->where('utilisateur_id', '!=', auth()->id())
                ->with(['utilisateur', 'validatedBy', 'rejectedBy', 'approvedBy'])
                ->orderBy('created_at', 'desc')
                ->paginate(10, ['*'], 'besoins_page');

            // Récupérer les besoins personnels du chef de département
            $mesBesoins = BesoinBudgetaire::where('utilisateur_id', auth()->id())
                ->orderBy('created_at', 'desc')
                ->paginate(10, ['*'], 'mes_besoins_page');

            // Récupérer les besoins validés définitivement
            $besoinsValides = BesoinBudgetaire::where('departement_id', $chefDepartement->departement_id)
                ->where('status', 'validated_by_chef')
                ->with(['utilisateur', 'validatedBy', 'rejectedBy', 'approvedBy'])
                ->orderBy('created_at', 'desc')
                ->paginate(10, ['*'], 'besoins_valides_page');

            // Statistiques
            $totalBesoins = BesoinBudgetaire::where('departement_id', $chefDepartement->departement_id)->count();
            $besoinsEnAttente = BesoinBudgetaire::where('departement_id', $chefDepartement->departement_id)
                ->where('status', 'approved_by_rf')
                ->count();
            $nombreBesoinsValides = BesoinBudgetaire::where('departement_id', $chefDepartement->departement_id)
                ->where('status', 'validated_by_chef')
                ->count();
            $besoinsRejetes = BesoinBudgetaire::where('departement_id', $chefDepartement->departement_id)
                ->whereIn('status', ['rejected_by_chef', 'rejected_by_rf'])
                ->count();

            return view('chef-departement.dashboard', compact(
                'besoinsAValider',
                'mesBesoins',
                'professeurs',
                'totalBesoins',
                'besoinsEnAttente',
                'besoinsValides',
                'nombreBesoinsValides',
                'besoinsRejetes'
            ));
        } catch (\Exception $e) {
            \Log::error('Erreur dans le dashboard du chef de département', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->route('dashboard')
                ->with('error', 'Une erreur est survenue lors du chargement du tableau de bord.');
        }
    }

    public function createProfesseur()
    {
        return view('chef-departement.create-professeur');
    }

    public function storeProfesseur(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:utilisateurs',
            'specialite' => 'required|string|max:255',
            'grade' => 'required|string|max:255',
            'is_responsable_financier' => 'sometimes'
        ]);

        DB::beginTransaction();
        try {
            $chefDepartement = ChefDepartement::where('utilisateur_id', auth()->id())->first();

            // Générer un mot de passe initial
            $motDePasseInitial = Str::random(8);

            // Convertir la valeur de la case à cocher en booléen
            $isResponsableFinancier = $request->has('is_responsable_financier');

            $utilisateur = Utilisateur::create([
                'nom' => $request->nom,
                'prenom' => $request->prenom,
                'email' => $request->email,
                'password' => Hash::make($motDePasseInitial),
                'role' => $isResponsableFinancier ? 'responsable_financier' : 'professeur',
                'status' => 'actif',
                'date_creation' => now(),
                'created_by' => auth()->id(),
                'must_change_password' => true
            ]);

            $professeur = Professeur::create([
                'utilisateur_id' => $utilisateur->id,
                'departement_id' => $chefDepartement->departement_id,
                'specialite' => $request->specialite,
                'grade' => $request->grade,
                'status' => 'actif'
            ]);

            // Si l'utilisateur est désigné comme responsable financier
            if ($isResponsableFinancier) {
                // Vérifier s'il existe déjà un responsable financier actif pour ce département
                $existingResponsable = ResponsableFinancier::where('departement_id', $chefDepartement->departement_id)
                    ->where('status', 'actif')
                    ->first();

                if ($existingResponsable) {
                    // Désactiver l'ancien responsable financier
                    $existingResponsable->status = 'inactif';
                    $existingResponsable->save();
                }

                // Créer le nouveau responsable financier
                ResponsableFinancier::create([
                    'utilisateur_id' => $utilisateur->id,
                    'departement_id' => $chefDepartement->departement_id,
                    'status' => 'actif'
                ]);
            }

            DB::commit();

            // Stocker le mot de passe dans la session pour l'afficher une seule fois
            session()->flash('initial_password', $motDePasseInitial);

            return redirect()->route('chef-departement.dashboard')
                ->with('success', 'Professeur créé avec succès. Le mot de passe initial est : ' . $motDePasseInitial);
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Erreur lors de la création du professeur : ' . $e->getMessage());
        }
    }

    public function professeurs()
    {
        $chefDepartement = ChefDepartement::where('utilisateur_id', auth()->id())->first();
        $professeurs = Professeur::where('departement_id', $chefDepartement->departement_id)
            ->with('utilisateur')
            ->get();

        return view('chef-departement.professeurs', compact('professeurs'));
    }

    public function createBesoin()
    {
        return view('chef-departement.create-besoin');
    }

    public function storeBesoin(Request $request)
    {
        try {
            \Log::info('Début de la méthode storeBesoin dans ChefDepartementController');

            // Récupérer le chef de département
            $chefDepartement = ChefDepartement::where('utilisateur_id', auth()->id())->first();

            if (!$chefDepartement) {
                \Log::error('Chef de département non trouvé pour l\'utilisateur: ' . auth()->id());
                return redirect()->back()->with('error', 'Chef de département non trouvé.');
            }

            // Déterminer quel groupe de champs est actif
            $isGroup1 = in_array($request->type, ['materiel_cours', 'materiel_imprimerie', 'materiel_roulant']);
            $suffix = $isGroup1 ? '1' : '2';

            // Règles de validation
            $rules = [
                'type' => 'required|string',
                'designation' . $suffix => 'required|string',
                'motif' . $suffix => 'required|string',
                'quantite' . $suffix => 'required|numeric|min:1',
                'cout_unitaire' . $suffix => 'required|numeric|min:0',
                'cout_total' . $suffix => 'required|numeric|min:0',
                'periode' => 'required|string',
                'source_financement' => 'required|string',
                'priorite' => 'required|in:low,medium,high'
            ];

            \Log::info('Règles de validation:', $rules);

            // Valider les données
            $validatedData = $request->validate($rules);

            \Log::info('Données validées:', $validatedData);

            // Créer le besoin budgétaire
            $besoin = BesoinBudgetaire::create([
                'type' => $validatedData['type'],
                'designation' => $validatedData['designation' . $suffix],
                'motif' => $validatedData['motif' . $suffix],
                'quantite' => $validatedData['quantite' . $suffix],
                'cout_unitaire' => $validatedData['cout_unitaire' . $suffix],
                'cout_total' => $validatedData['cout_total' . $suffix],
                'periode' => $validatedData['periode'],
                'source_financement' => $validatedData['source_financement'],
                'priorite' => $validatedData['priorite'],
                'status' => 'pending',
                'departement_id' => $chefDepartement->departement_id,
                'utilisateur_id' => auth()->id()
            ]);

            \Log::info('Besoin budgétaire créé avec succès:', $besoin->toArray());

            return redirect()->route('chef-departement.dashboard')
                ->with('success', 'Le besoin budgétaire a été enregistré avec succès.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Erreur de validation:', [
                'errors' => $e->errors(),
                'request_data' => $request->all()
            ]);
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            \Log::error('Erreur lors de la création du besoin budgétaire:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);
            return redirect()->back()
                ->with('error', 'Une erreur est survenue lors de l\'enregistrement du besoin budgétaire.')
                ->withInput();
        }
    }

    public function besoins()
    {
        $chefDepartement = ChefDepartement::where('utilisateur_id', auth()->id())->first();
        $besoins = BesoinBudgetaire::where('departement_id', $chefDepartement->departement_id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('chef-departement.besoins', compact('besoins'));
    }

    public function showBesoin($id)
    {
        $chefDepartement = ChefDepartement::where('utilisateur_id', auth()->id())->first();
        $besoin = BesoinBudgetaire::where('departement_id', $chefDepartement->departement_id)
            ->where('id', $id)
            ->with('utilisateur')
            ->firstOrFail();

        return view('chef-departement.show-besoin', compact('besoin'));
    }

    public function validateBesoin($id)
    {
        $chefDepartement = ChefDepartement::where('utilisateur_id', auth()->id())->first();
        $besoin = BesoinBudgetaire::where('departement_id', $chefDepartement->departement_id)
            ->where('id', $id)
            ->where('status', 'approved_by_rf')
            ->firstOrFail();

        $besoin->update([
            'status' => 'validated_by_chef',
            'validated_by' => auth()->id(),
            'validated_at' => now()
        ]);

        return redirect()->route('chef-departement.show-besoin', $besoin->id)
            ->with('success', 'Le besoin a été validé définitivement.');
    }

    public function rejectBesoin(Request $request, $id)
    {
        $request->validate([
            'motif_rejet' => 'required|string|max:255'
        ]);

        $chefDepartement = ChefDepartement::where('utilisateur_id', auth()->id())->first();
        $besoin = BesoinBudgetaire::where('departement_id', $chefDepartement->departement_id)
            ->where('id', $id)
            ->where('status', 'approved_by_rf')
            ->firstOrFail();

        $besoin->update([
            'status' => 'rejected_by_chef',
            'rejected_by' => auth()->id(),
            'rejected_at' => now(),
            'motif_rejet' => $request->motif_rejet
        ]);

        return redirect()->route('chef-departement.show-besoin', $besoin->id)
            ->with('success', 'Le besoin a été rejeté.');
    }

    public function editBesoin($id)
    {
        $chefDepartement = ChefDepartement::where('utilisateur_id', auth()->id())->first();
        $besoin = BesoinBudgetaire::where('departement_id', $chefDepartement->departement_id)
            ->where('utilisateur_id', auth()->id())
            ->where('id', $id)
            ->where('status', 'pending')
            ->firstOrFail();

        return view('chef-departement.edit-besoin', compact('besoin'));
    }

    public function updateBesoin(Request $request, $id)
    {
        try {
            $chefDepartement = ChefDepartement::where('utilisateur_id', auth()->id())->first();
            $besoin = BesoinBudgetaire::where('departement_id', $chefDepartement->departement_id)
                ->where('utilisateur_id', auth()->id())
                ->where('id', $id)
                ->where('status', 'pending')
                ->firstOrFail();

            // Déterminer quel groupe de champs est actif
            $isGroup1 = in_array($request->type, ['materiel_cours', 'materiel_imprimerie', 'materiel_roulant']);
            $suffix = $isGroup1 ? '1' : '2';

            // Règles de validation
            $rules = [
                'type' => 'required|string',
                'designation' . $suffix => 'required|string',
                'motif' . $suffix => 'required|string',
                'quantite' . $suffix => 'required|numeric|min:1',
                'cout_unitaire' . $suffix => 'required|numeric|min:0',
                'cout_total' . $suffix => 'required|numeric|min:0',
                'periode' => 'required|string',
                'source_financement' => 'required|string',
                'priorite' => 'required|in:low,medium,high'
            ];

            // Valider les données
            $validatedData = $request->validate($rules);

            // Mettre à jour le besoin budgétaire
            $besoin->update([
                'type' => $validatedData['type'],
                'designation' => $validatedData['designation' . $suffix],
                'motif' => $validatedData['motif' . $suffix],
                'quantite' => $validatedData['quantite' . $suffix],
                'cout_unitaire' => $validatedData['cout_unitaire' . $suffix],
                'cout_total' => $validatedData['cout_total' . $suffix],
                'periode' => $validatedData['periode'],
                'source_financement' => $validatedData['source_financement'],
                'priorite' => $validatedData['priorite']
            ]);

            return redirect()->route('chef-departement.dashboard')
                ->with('success', 'Le besoin budgétaire a été mis à jour avec succès.');

        } catch (\Exception $e) {
            \Log::error('Erreur lors de la mise à jour du besoin budgétaire:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()
                ->with('error', 'Une erreur est survenue lors de la mise à jour du besoin budgétaire.')
                ->withInput();
        }
    }

    public function deleteBesoin($id)
    {
        try {
            $chefDepartement = ChefDepartement::where('utilisateur_id', auth()->id())->first();
            $besoin = BesoinBudgetaire::where('departement_id', $chefDepartement->departement_id)
                ->where('utilisateur_id', auth()->id())
                ->where('id', $id)
                ->where('status', 'pending')
                ->firstOrFail();

            $besoin->delete();

            return redirect()->route('chef-departement.dashboard')
                ->with('success', 'Le besoin budgétaire a été supprimé avec succès.');

        } catch (\Exception $e) {
            \Log::error('Erreur lors de la suppression du besoin budgétaire:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()
                ->with('error', 'Une erreur est survenue lors de la suppression du besoin budgétaire.');
        }
    }
}
