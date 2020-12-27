<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Etat;
use App\Models\DemandesSpecifiques;

class EtatController extends Controller
{
    public function afficher()
    {
        session_start();

        if (!isset($_SESSION['mail'])) {
            header('Refresh: 0; url=http://localhost/PPE-3/Application/server.php?inactiviteprolonge=true');
            exit;
        }

        return view('suivi');
    }

    public function majetatdemande(Request $request)
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
