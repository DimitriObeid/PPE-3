<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Etat;
use App\Models\DemandesSpecifiques;
use App\Models\Commandes;

class EtatController extends Controller
{
    public function majetatdemande(Request $request)
    {
        session_start();

        $idetat = Etat::select('id')->where('nomEtat', $request->etat)->get();

        $DemandesSpecifiques = DemandesSpecifiques::join('etats', 'demandes_specifiques.idEtat', 'etats.id')->where('demandes_specifiques.id', $request->id)->update(['demandes_specifiques.idEtat' => $idetat[0]->id]);

        $demandes_pers = DemandesSpecifiques::join('etats', 'demandes_specifiques.idEtat', 'etats.id')->join('personnels', 'demandes_specifiques.idPersonnel', 'personnels.id')->select('demandes_specifiques.*', 'nomEtat', 'mail')->where('mail', $_SESSION['mail'])->orderby('demandes_specifiques.id', 'asc')->get();

        $demandes_valid = DemandesSpecifiques::join('etats', 'demandes_specifiques.idEtat', 'etats.id')->join('personnels', 'demandes_specifiques.idPersonnel', 'personnels.id')->join('services', 'personnels.idService', 'services.id')->select('demandes_specifiques.*', 'nomEtat', 'nom', 'prenom', 'nomService')->where('nomService', $_SESSION['service'])->orderby('demandes_specifiques.id', 'asc')->get();

        $_SESSION['demandes_pers'] = $demandes_pers;
        $_SESSION['demandes_valid'] = $demandes_valid;

        $envoyer = true;

        return view('demandesspecifiques', ['envoyer'=>$envoyer]);
    }

    public function majetatcommande(Request $request)
    {
        session_start();

        $idetat = Etat::select('id')->where('nomEtat', $request->etat)->get();

        $Commandes = Commandes::join('etats', 'commandes.idEtat', 'etats.id')->where('commandes.id', $request->id)->update(['commandes.idEtat' => $idetat[0]->id]);

        $commande_utilisateur = Commandes::join('personnels', 'commandes.idPersonnel', 'personnels.id')->join('etats', 'commandes.idEtat', 'etats.id')->join('fournitures', 'commandes.idFournitures', 'fournitures.id')->select('commandes.*', 'mail', 'nomEtat')->where('mail', $_SESSION['mail'])->orderby('commandes.id', 'asc')->get();

        $commande_valid = Commandes::join('personnels', 'commandes.idPersonnel', 'personnels.id')->join('services', 'personnels.idService', 'services.id')->join('etats', 'commandes.idEtat', 'etats.id')->join('fournitures', 'commandes.idFournitures', 'fournitures.id')->select('commandes.*', 'nom', 'prenom', 'nomEtat', 'nomService')->where('nomService', $_SESSION['service'])->orderby('commandes.id', 'asc')->get();

        $_SESSION['commande_utilisateur'] = $commande_utilisateur;
        $_SESSION['commande_valid'] = $commande_valid;

        $envoyer = true;

        return view('suivi', ['envoyer'=>$envoyer]);
    }
}
