<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DemandesSpecifiques;
use App\Models\Personnel;
use App\Models\Fournitures;
use App\Models\Categorie;
use App\Models\Commandes;
use App\Models\Etat;
use App\Models\Service;

class DemandesSpecifiquesController extends Controller
{
    public function afficher()
    {
        session_start();

        $demandes = DemandesSpecifiques::join('etat', 'demandes_specifiques.idEtat', 'etat.id')->join('personnels', 'demandes_specifiques.idPersonnel', 'personnels.id')->select('demandes_specifiques.*', 'nomEtat', 'nom', 'prenom')->orderby('demandes_specifiques.id', 'asc')->get();

        $demandes_pers = DemandesSpecifiques::join('etat', 'demandes_specifiques.idEtat', 'etat.id')->join('personnels', 'demandes_specifiques.idPersonnel', 'personnels.id')->select('demandes_specifiques.*', 'nomEtat', 'mail')->where('mail', $_SESSION['mail'])->orderby('demandes_specifiques.id', 'asc')->get();

        $demandes_valid = DemandesSpecifiques::join('etat', 'demandes_specifiques.idEtat', 'etat.id')->join('personnels', 'demandes_specifiques.idPersonnel', 'personnels.id')->join('service', 'personnels.idService', 'service.id')->select('demandes_specifiques.*', 'nomEtat', 'nom', 'prenom', 'nomService')->where('nomService', $_SESSION['service'])->orderby('demandes_specifiques.id', 'asc')->get();

        $_SESSION['demandes'] = $demandes;
        $_SESSION['demandes_pers'] = $demandes_pers;
        $_SESSION['demandes_valid'] = $demandes_valid;

        return view('demandesspecifiques');
    }

    public function creation(Request $request)
    {
        session_start();

        $id_personnel = Personnel::where('mail', $_SESSION['mail'])->select('id')->get();

        $validatedData = $request->validate([
        'nom_demande' => 'required|max:50',
        'quantite_demande' => 'required',
        'lien_produit' => 'max:1000',
        ]);

        $DemandesSpecifiques = new DemandesSpecifiques;

        $DemandesSpecifiques->nomDemande = $request->nom_demande;
        $DemandesSpecifiques->quantiteDemande = $request->quantite_demande;
        $DemandesSpecifiques->lienProduit = $request->lien_produit ?? '';
        $DemandesSpecifiques->idEtat = '1';
        $DemandesSpecifiques->idPersonnel = $id_personnel[0]->id;

        $DemandesSpecifiques->save();

        $demandes_pers = DemandesSpecifiques::join('etat', 'demandes_specifiques.idEtat', 'etat.id')->join('personnels', 'demandes_specifiques.idPersonnel', 'personnels.id')->select('demandes_specifiques.*', 'nomEtat', 'mail')->where('mail', $_SESSION['mail'])->orderby('demandes_specifiques.id', 'asc')->get();

        $_SESSION['demandes_pers'] = $demandes_pers;

        $vrai = true;

        return view('demandesspecifiques', ['vrai'=>$vrai]);
    }
}
