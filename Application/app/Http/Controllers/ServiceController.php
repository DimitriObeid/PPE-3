<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;

class ServiceController extends Controller
{
    public function afficher()
    {
        session_start();

        if (!isset($_SESSION['mail'])) {
            header('Refresh: 0; url=http://localhost/PPE-3/Application/server.php?inactiviteprolonge=true');
            exit;
        }

        $ServiceUtilvalideur = Service::join('personnels', 'services.id', 'personnels.idService')->join('categories', 'personnels.idCategorie', 'categories.id')->select('services.*', 'nom', 'prenom', 'mail', 'nomCategorie')->where('nomService', $_SESSION['service'])->where('nomCategorie', 'Valideur')->get();

        $ServiceUtil = Service::select('services.*')->where('nomService', $_SESSION['service'])->get();

        if (isset($ServiceUtilvalideur[0])) {
            $_SESSION['service_util'] = $ServiceUtilvalideur;
        } else {
            $_SESSION['service_util'] = $ServiceUtil;
        }

        return view('departements');
    }
}
