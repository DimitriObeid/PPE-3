<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Personnel;
use App\Models\Fournitures;
use App\Models\Categorie;
use App\Models\Commandes;
use App\Models\Etat;
use App\Models\Service;

class PersonnelController extends Controller
{
    public function creer()
    {
        return view('inscription');
    }

    public function verif_creer(Request $request)
    {
        $validatedData = $request->validate([
        'nom' => 'required|max:50',
        'prenom' => 'required|max:50',
        'email' => 'required|email',
        'mdp' => 'required|max:50',
        ]);

        $Personnel = new Personnel;

        $Personnel->nom = $request->nom;
        $Personnel->prenom = $request->prenom;
        $Personnel->mail = $request->email;
        $Personnel->pass = password_hash($request->mdp, PASSWORD_DEFAULT);
        $Personnel->idCategorie = $request->categorie;
        $Personnel->idService = $request->service;

        $Personnel->save();

        return $this->connexion($request);
    }

    public function connexion(Request $request)
    {
        $validatedData = $request->validate([
        'email' => 'required|email',
        'mdp' => 'required|max:50',
        ]);

        $Personnel = Personnel::join('service', 'personnels.idService', 'service.id')->join('categorie', 'personnels.idCategorie', 'categorie.id')->where('mail', $request->email)->get();

        $test = $Personnel->last();

        if ($test == null)
        {
            $erreur = 'mail';
            return view('connexion', ['erreur'=>$erreur]);
        }
        elseif (!password_verify($request->mdp, $Personnel[0]->pass))
        {
            $erreur = 'mdp';
            return view('connexion', ['erreur'=>$erreur]);
        }
        elseif ($request->email == $Personnel[0]->mail AND password_verify($request->mdp, $Personnel[0]->pass))
        {
            session_start();

            $_SESSION['nom'] = $Personnel[0]->nom;
            $_SESSION['prenom'] = $Personnel[0]->prenom;
            $_SESSION['mail'] = $Personnel[0]->mail;
            $_SESSION['pass'] = $Personnel[0]->pass;
            $_SESSION['categorie'] = $Personnel[0]->nomCategorie;
            $_SESSION['service'] = $Personnel[0]->nomService;
            $_SESSION['message'] = $Personnel[0]->message;

            $Personnels = Personnel::join('service', 'personnels.idService', 'service.id')->join('categorie', 'personnels.idCategorie', 'categorie.id')->select('*')->orderby('personnels.id', 'asc')->get();

            $Fournitures = Fournitures::select('fournitures.*')->get();

            return view('accueil', ['Personnels'=>$Personnels], ['Fournitures'=>$Fournitures]);
        }
    }

    public function deconnexion()
    {
        session_start();

        $_SESSION = array();
        session_destroy();

        setcookie('login', '');
        setcookie('pass_hache', '');

        return view('connexion');
    }

    public function dashboard()
    {
        session_start();

        $Personnels = Personnel::join('service', 'personnels.idService', 'service.id')->join('categorie', 'personnels.idCategorie', 'categorie.id')->select('*')->orderby('personnels.id', 'asc')->get();

        $Fournitures = Fournitures::select('fournitures.*')->get();

        return view('accueil', ['Personnels'=>$Personnels], ['Fournitures'=>$Fournitures]);
    }

    public function message(Request $request)
    {
        $Personnel = Personnel::where('mail', $request->mail)->update(['message' => $request->message]);

        session_start();

        $Personnels = Personnel::join('service', 'personnels.idService', 'service.id')->join('categorie', 'personnels.idCategorie', 'categorie.id')->select('*')->orderby('personnels.id', 'asc')->get();

        $vrai = true;

        return view('accueil', ['Personnels'=>$Personnels], ['vrai'=>$vrai]);
    }

    public function supprimer(Request $request)
    {
        $Personnel = Personnel::where('mail', $request->mail)->update(['message' => '']);

        session_start();

        $Personnels = Personnel::join('service', 'personnels.idService', 'service.id')->join('categorie', 'personnels.idCategorie', 'categorie.id')->select('*')->orderby('personnels.id', 'asc')->get();

        $suppr = true;

        return view('accueil', ['Personnels'=>$Personnels], ['suppr'=>$suppr]);

    }
}
