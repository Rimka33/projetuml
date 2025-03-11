<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Directeur extends Model
{
    use HasFactory;

    protected $table = 'directeurs';

    protected $fillable = [
        'utilisateur_id',
        'status'
    ];

    public function utilisateur()
    {
        return $this->belongsTo(Utilisateur::class, 'utilisateur_id');
    }
}
