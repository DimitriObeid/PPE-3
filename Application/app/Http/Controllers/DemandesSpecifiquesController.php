<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DemandesSpecifiques;

class DemandesSpecifiquesController extends Controller
{
    public function afficher()
    {
        $demandes = DemandesSpecifiques::join('etat', 'demandes_specifiques.idEtat', 'etat.id')->join('personnels', 'demandes_specifiques.idPersonnel', 'personnels.id')->select('*')->orderby('demandes_specifiques.id', 'asc')->get();

        session_start();

        $_SESSION['demandes'] = $demandes;

        return view('demandesspecifiques');
    }
}
