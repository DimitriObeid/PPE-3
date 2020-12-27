<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fournitures;

class FournituresController extends Controller
{
    public function afficher()
    {
        session_start();

        if (!isset($_SESSION['mail'])) {
            header('Refresh: 0; url=http://localhost/PPE-3/Application/server.php?inactiviteprolonge=true');
            exit;
        }

        return view('fournitures');
    }

    public function rechercher(Request $request)
    {
        session_start();

        $rechercheExplode = explode(' ', $request->recherche);

        $recherche = implode('%', $rechercheExplode);

        $resultat = Fournitures::where('nomFournitures', 'like', '%'.$recherche.'%')->get();

        $_SESSION['recherche'] = $resultat;

        if (isset($_SESSION['recherche'][0])) {
            $reponse = true;
        } else {
            $reponse = false;
        }

        return view('fournitures', ['reponse' => $reponse]);
    }

    public function creationfourniture(Request $request)
    {
        session_start();

        $nomMinuscules = strtolower($request->nom_fourniture);

        $nomExplode = explode(' ', $nomMinuscules);

        $nomPhoto = implode('-', $nomExplode);

        if ($request->file('photo_fournitures')->getsize() > 500000) {

            $tropgros = true;

            return view('fournitures', ['tropgros' => $tropgros]);
        }

        $fichierTelecharger = $request->file('photo_fournitures');
        switch (exif_imagetype($fichierTelecharger)) {
            case IMAGETYPE_JPEG:
                $photo = imagecreatefromjpeg($fichierTelecharger);
                break;
            case IMAGETYPE_GIF:
                $photo = imagecreatefromgif($fichierTelecharger);
                break;
            case IMAGETYPE_BMP:
                $photo = imagecreatefrombmp($fichierTelecharger);
                break;
            case IMAGETYPE_PNG:
                $photo = imagecreatefrompng($fichierTelecharger);
                break;
            default:
                $invalide = true;
                return view('fournitures', ['invalide' => $invalide]);
                break;
        }

        $nomChemin = '/var/www/html/PPE-3/Application/storage/app/public/'.$nomPhoto.'.jpg';

        imagejpeg($photo, $nomChemin);

        $Fournitures = new Fournitures;

        $Fournitures->nomFournitures = $request->nom_fourniture;
        $Fournitures->nomPhoto = $nomPhoto;
        $Fournitures->descriptionFournitures = $request->description_fourniture;
        $Fournitures->quantiteDisponible = $request->quantite_disponible;

        $Fournitures->save();

        $Fournitures = Fournitures::select('fournitures.*')->get();

        $_SESSION['fournitures'] = $Fournitures;

        $cree = true;

        return view('fournitures', ['cree' => $cree]);
    }

    public function majquantite(Request $request)
    {
        session_start();

        $majquantite = Fournitures::where('id', $request->id)->update(['quantiteDisponible' => $request->quantite_disponible]);

        $Fournitures = Fournitures::select('fournitures.*')->get();

        $_SESSION['fournitures'] = $Fournitures;

        $valider = true;

        return view('fournitures', ['valider' => $valider]);
    }
}
