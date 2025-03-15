<?php

namespace App\Http\Controllers;

use App\Models\BesoinBudgetaire;
use App\Models\Professeur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProfesseurController extends Controller
{
    public function dashboard()
    {
        $professeur = Professeur::where('utilisateur_id', auth()->id())->first();

        if (!$professeur) {
            return redirect()->route('dashboard')
                ->with('error', 'Erreur : Professeur non trouvé.');
        }

        $besoins = BesoinBudgetaire::where('utilisateur_id', auth()->id())
            ->with(['validatedBy', 'rejectedBy', 'approvedBy'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $totalBesoins = BesoinBudgetaire::where('utilisateur_id', auth()->id())->count();
        $besoinsEnAttente = BesoinBudgetaire::where('utilisateur_id', auth()->id())
            ->whereIn('status', ['pending', 'validated_by_chef'])
            ->count();
        $besoinsApprouves = BesoinBudgetaire::where('utilisateur_id', auth()->id())
            ->where('status', 'approved')
            ->count();
        $besoinsRejetes = BesoinBudgetaire::where('utilisateur_id', auth()->id())
            ->whereIn('status', ['rejected_by_chef', 'rejected'])
            ->count();

        return view('professeur.dashboard', compact('besoins', 'totalBesoins', 'besoinsEnAttente', 'besoinsApprouves', 'besoinsRejetes'));
    }

    public function besoins()
    {
        $besoins = BesoinBudgetaire::where('utilisateur_id', auth()->id())
            ->with(['validatedBy', 'rejectedBy', 'approvedBy'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('professeur.besoins', compact('besoins'));
    }

    public function showBesoin($id)
    {
        $besoin = BesoinBudgetaire::where('utilisateur_id', auth()->id())
            ->where('id', $id)
            ->with(['validatedBy', 'rejectedBy', 'approvedBy'])
            ->firstOrFail();

        return view('professeur.show-besoin', compact('besoin'));
    }

    public function createBesoin()
    {
        return view('professeur.create-besoin');
    }

    public function storeBesoin(Request $request)
    {
        try {
            \Log::info('Début de la méthode storeBesoin dans ProfesseurController');

            // Récupérer le professeur
            $professeur = Professeur::where('utilisateur_id', auth()->id())->first();

            if (!$professeur) {
                \Log::error('Professeur non trouvé pour l\'utilisateur: ' . auth()->id());
                return redirect()->back()->with('error', 'Professeur non trouvé.');
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
                'departement_id' => $professeur->departement_id,
                'utilisateur_id' => auth()->id()
            ]);

            \Log::info('Besoin budgétaire créé avec succès:', $besoin->toArray());

            return redirect()->route('professeur.dashboard')
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
}
