<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectBasedOnRole
{
    public function handle(Request $request, Closure $next): Response
    {
        // Ne redirige que si l'utilisateur est authentifié et essaie d'accéder au dashboard général
        if ($request->user() && $request->route()->getName() === 'dashboard') {
            switch ($request->user()->role) {
                case 'admin':
                    return redirect()->route('admin.dashboard');
                case 'chef_departement':
                    return redirect()->route('chef-departement.dashboard');
                case 'professeur':
                    return redirect()->route('professeur.dashboard');
                case 'directeur':
                    return redirect()->route('directeur.dashboard');
                case 'responsable_financier':
                    return redirect()->route('responsable-financier.dashboard');
                default:
                    return redirect('/');
            }
        }

        return $next($request);
    }
}
