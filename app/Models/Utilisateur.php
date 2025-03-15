<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Utilisateur extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'password',
        'role',
        'status',
        'date_creation',
        'created_by',
        'profile_image'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'date_creation' => 'datetime',
        'password' => 'hashed',
    ];

    // Relations
    public function chefDepartement()
    {
        return $this->hasOne(ChefDepartement::class);
    }

    public function directeur()
    {
        return $this->hasOne(Directeur::class);
    }
}
