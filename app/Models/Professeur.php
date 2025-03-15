<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Professeur extends Model
{
    use HasFactory;

    protected $table = 'professeurs';

    protected $fillable = [
        'utilisateur_id',
        'departement_id',
        'specialite',
        'grade',
        'status'
    ];

    public function utilisateur()
    {
        return $this->belongsTo(Utilisateur::class);
    }

    public function departement()
    {
        return $this->belongsTo(Departement::class);
    }

    public function besoins()
    {
        return $this->hasMany(BesoinBudgetaire::class);
    }
}
