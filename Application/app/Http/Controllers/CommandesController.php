<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Commandes;
use App\Models\Personnel;
use App\Models\Fournitures;

class CommandesController extends Controller
{
    public function afficher()
    {
        session_start();

        if (!isset($_SESSION['mail'])) {
            header('Refresh: 0; url=http://localhost/PPE-3/Application/server.php?inactiviteprolonge=true');
            exit;
        }

        $commande_utilisateur = Commandes::join('personnels', 'commandes.idPersonnel', 'personnels.id')->join('etats', 'commandes.idEtat', 'etats.id')->join('fournitures', 'commandes.idFournitures', 'fournitures.id')->select('commandes.*', 'mail', 'nomEtat')->where('mail', $_SESSION['mail'])->orderby('commandes.id', 'asc')->get();

        $commande_complet = Commandes::join('personnels', 'commandes.idPersonnel', 'personnels.id')->join('etats', 'commandes.idEtat', 'etats.id')->join('fournitures', 'commandes.idFournitures', 'fournitures.id')->select('commandes.*', 'nom', 'prenom', 'nomEtat')->orderby('commandes.id', 'asc')->get();

        $commande_valid = Commandes::join('personnels', 'commandes.idPersonnel', 'personnels.id')->join('services', 'personnels.idService', 'services.id')->join('etats', 'commandes.idEtat', 'etats.id')->join('fournitures', 'commandes.idFournitures', 'fournitures.id')->select('commandes.*', 'nom', 'prenom', 'nomEtat', 'nomService')->where('nomService', $_SESSION['service'])->orderby('commandes.id', 'asc')->get();

        $_SESSION['commande_utilisateur'] = $commande_utilisateur;
        $_SESSION['commande_complet'] = $commande_complet;
        $_SESSION['commande_valid'] = $commande_valid;

        return view('suivi');
    }

    public function commander(Request $request)
    {
        session_start();

        $id_personnel = Personnel::where('mail', $_SESSION['mail'])->select('id')->get();

        $quantite = Fournitures::where('id', $request->id)->select('quantiteDisponible')->get();

        $nouv_quantite = $quantite[0]->quantiteDisponible - $request->quantite_demande;

        $majquantite = Fournitures::where('id', $request->id)->update(['quantiteDisponible' => $nouv_quantite]);

        $Commandes = new Commandes;

        $Commandes->idEtat = '1';
        $Commandes->idFournitures = $request->id;
        $Commandes->idPersonnel = $id_personnel[0]->id;
        $Commandes->nomCommandes = $request->nom_fourniture;
        $Commandes->quantiteDemande = $request->quantite_demande;

        $Commandes->save();

        $Fournitures = Fournitures::select('fournitures.*')->get();

        $commande_utilisateur = Commandes::join('personnels', 'commandes.idPersonnel', 'personnels.id')->join('etats', 'commandes.idEtat', 'etats.id')->join('fournitures', 'commandes.idFournitures', 'fournitures.id')->select('commandes.*', 'personnels.mail', 'etats.nomEtat')->where('personnels.mail', $_SESSION['mail'])->orderby('commandes.id', 'asc')->get();

        $_SESSION['fournitures'] = $Fournitures;
        $_SESSION['commande_utilisateur'] = $commande_utilisateur;

        $commande_cree = true;

        return view('fournitures', ['commande_cree'=>$commande_cree]);
    }
}
