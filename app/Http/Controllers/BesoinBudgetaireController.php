<?php

namespace App\Http\Controllers;

use App\Models\BesoinBudgetaire;
use App\Traits\ProcessStepTrait;
use Illuminate\Http\Request;

class BesoinBudgetaireController extends Controller
{
    use ProcessStepTrait;

    public function show(BesoinBudgetaire $besoin)
    {
        $this->setProcessStep($besoin->status);
        return view('besoins.show', compact('besoin'));
    }

    public function create()
    {
        $this->setProcessStep('pending');
        return view('besoins.create');
    }

    // ... existing code ...
}
