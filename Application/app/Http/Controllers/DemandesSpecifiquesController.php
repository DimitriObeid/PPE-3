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

        $demandes = DemandesSpecifiques::join('etats', 'demandes_specifiques.idEtat', 'etats.id')->join('personnels', 'demandes_specifiques.idPersonnel', 'personnels.id')->select('demandes_specifiques.*', 'nomEtat', 'nom', 'prenom')->orderby('demandes_specifiques.id', 'asc')->get();

        $demandes_pers = DemandesSpecifiques::join('etats', 'demandes_specifiques.idEtat', 'etats.id')->join('personnels', 'demandes_specifiques.idPersonnel', 'personnels.id')->select('demandes_specifiques.*', 'nomEtat', 'mail')->where('mail', $_SESSION['mail'])->orderby('demandes_specifiques.id', 'asc')->get();

        $demandes_valid = DemandesSpecifiques::join('etats', 'demandes_specifiques.idEtat', 'etats.id')->join('personnels', 'demandes_specifiques.idPersonnel', 'personnels.id')->join('service', 'personnels.idService', 'service.id')->select('demandes_specifiques.*', 'nomEtat', 'nom', 'prenom', 'nomService')->where('nomService', $_SESSION['service'])->orderby('demandes_specifiques.id', 'asc')->get();

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
        'nom_demande' => 'required',
        ]);

        $DemandesSpecifiques = new DemandesSpecifiques;

        $DemandesSpecifiques->nomDemande = $request->nom_demande;
        $DemandesSpecifiques->quantiteDemande = $request->quantite_demande;
        $DemandesSpecifiques->lienProduit = $request->lien_produit ?? 'Aucun lien fourni';
        $DemandesSpecifiques->idEtat = '1';
        $DemandesSpecifiques->idPersonnel = $id_personnel[0]->id;

        $DemandesSpecifiques->save();

        $demandes_pers = DemandesSpecifiques::join('etats', 'demandes_specifiques.idEtat', 'etats.id')->join('personnels', 'demandes_specifiques.idPersonnel', 'personnels.id')->select('demandes_specifiques.*', 'nomEtat', 'mail')->where('mail', $_SESSION['mail'])->orderby('demandes_specifiques.id', 'asc')->get();

        $_SESSION['demandes_pers'] = $demandes_pers;

        $vrai = true;

        return view('demandesspecifiques', ['vrai'=>$vrai]);
    }

    public function majetat(Request $request)
    {
        session_start();

        $idetat = Etat::select('id')->where('nomEtat', $request->etat)->get();

        $DemandesSpecifiques = DemandesSpecifiques::join('etats', 'demandes_specifiques.idEtat', 'etats.id')->where('demandes_specifiques.id', $request->id)->update(['demandes_specifiques.idEtat' => $idetat[0]->id]);

        $demandes_valid = DemandesSpecifiques::join('etats', 'demandes_specifiques.idEtat', 'etats.id')->join('personnels', 'demandes_specifiques.idPersonnel', 'personnels.id')->join('service', 'personnels.idService', 'service.id')->select('demandes_specifiques.*', 'nomEtat', 'nom', 'prenom', 'nomService')->where('nomService', $_SESSION['service'])->orderby('demandes_specifiques.id', 'asc')->get();

        $_SESSION['demandes_valid'] = $demandes_valid;

        $envoyer = true;

        return view('demandesspecifiques', ['envoyer'=>$envoyer]);
    }
}
