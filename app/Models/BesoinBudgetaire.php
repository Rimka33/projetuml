<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BesoinBudgetaire extends Model
{
    use HasFactory;

    protected $table = 'besoin_budgetaires';

    protected $fillable = [
        'type',
        'designation',
        'motif',
        'description',
        'quantite',
        'cout_unitaire',
        'cout_total',
        'periode',
        'source_financement',
        'status',
        'priorite',
        'departement_id',
        'utilisateur_id',
        'validated_by',
        'validated_at',
        'rejected_by',
        'rejected_at',
        'approved_by',
        'approved_at',
        'motif_rejet'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'validated_at' => 'datetime',
        'rejected_at' => 'datetime',
        'approved_at' => 'datetime',
        'cout_unitaire' => 'decimal:2',
        'cout_total' => 'decimal:2',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'validated_at',
        'rejected_at',
        'approved_at'
    ];

    public function departement()
    {
        return $this->belongsTo(Departement::class);
    }

    public function utilisateur()
    {
        return $this->belongsTo(Utilisateur::class, 'utilisateur_id');
    }

    public function validatedBy()
    {
        return $this->belongsTo(Utilisateur::class, 'validated_by');
    }

    public function rejectedBy()
    {
        return $this->belongsTo(Utilisateur::class, 'rejected_by');
    }

    public function approvedBy()
    {
        return $this->belongsTo(Utilisateur::class, 'approved_by');
    }

    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'pending' => 'En attente de validation du responsable financier',
            'approved_by_rf' => 'Validé par le responsable financier - En attente du chef de département',
            'rejected_by_rf' => 'Rejeté par le responsable financier',
            'validated_by_chef' => 'Validé définitivement par le chef de département',
            'rejected_by_chef' => 'Rejeté par le chef de département',
            default => 'Statut inconnu'
        };
    }

    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'pending' => 'warning',
            'approved_by_rf' => 'info',
            'rejected_by_rf' => 'danger',
            'validated_by_chef' => 'success',
            'rejected_by_chef' => 'danger',
            default => 'secondary'
        };
    }
}
