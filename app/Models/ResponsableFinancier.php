<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ResponsableFinancier extends Model
{
    protected $table = 'responsable_financiers';

    protected $fillable = [
        'utilisateur_id',
        'departement_id',
        'status',
    ];

    /**
     * Obtenir l'utilisateur associé au responsable financier.
     */
    public function utilisateur(): BelongsTo
    {
        return $this->belongsTo(Utilisateur::class, 'utilisateur_id');
    }

    /**
     * Obtenir le département associé au responsable financier.
     */
    public function departement(): BelongsTo
    {
        return $this->belongsTo(Departement::class, 'departement_id');
    }
}
