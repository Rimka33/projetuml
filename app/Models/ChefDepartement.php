<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChefDepartement extends Model
{
    use HasFactory;

    protected $table = 'chef_departements';

    protected $fillable = [
        'utilisateur_id',
        'departement_id',
        'status'
    ];

    public function utilisateur()
    {
        return $this->belongsTo(Utilisateur::class, 'utilisateur_id');
    }

    public function departement()
    {
        return $this->belongsTo(Departement::class, 'departement_id');
    }
}
