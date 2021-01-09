<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Personnel;
use App\Models\Fournitures;
use App\Models\Categorie;
use App\Models\Commandes;
use App\Models\Etat;
use App\Models\Service;
use App\Models\DemandesSpecifiques;

class PersonnelController extends Controller
{
    public function creer()
    {
        $Services = Service::select('services.*')->orderby('id', 'asc')->get();

        return view('inscription', ['Services'=>$Services]);
    }

    public function verif_creer(Request $request)
    {
        $validatedData = $request->validate([
            'nom' => 'required|max:50',
            'prenom' => 'required|max:50',
            'email' => 'required|max:50|email',
            'mdp' => 'required',
            'categorie' => 'required',
            'service' => 'required',
        ]);

        $Personnel = new Personnel;

        $Personnel->nom = $request->nom;
        $Personnel->prenom = $request->prenom;
        $Personnel->mail = $request->email;
        $Personnel->pass = password_hash($request->mdp, PASSWORD_DEFAULT);
        $Personnel->idCategorie = $request->categorie;
        $Personnel->idService = $request->service;
        $Personnel->message = '';

        $Personnel->save();

        return $this->connexion($request);
    }

    public function connexion(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|email',
            'mdp' => 'required',
            'page' => 'required',
        ]);

        $Personnel = Personnel::join('services', 'personnels.idService', 'services.id')->join('categories', 'personnels.idCategorie', 'categories.id')->where('mail', $request->email)->get();

        if ($Personnel->isEmpty())
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
            $commande_fini = Commandes::join('personnels', 'commandes.idPersonnel', 'personnels.id')->join('etats', 'commandes.idEtat', 'etats.id')->select('commandes.id', 'nomCommandes', 'quantiteDemande', 'commandes.updated_at', 'personnels.mail', 'etats.nomEtat')->where('personnels.mail', $Personnel[0]->mail)->where('etats.nomEtat', 'Livré')->orWhere('etats.nomEtat', 'Annulé')->orderby('commandes.id', 'asc')->get();

            for ($i=0; $i < $commande_fini->count(); $i++) {
                $dateActuel = date_create(date('Y-m-d'));
                $dateCommande = date_create(date('Y-m-d', strtotime($commande_fini[$i]->updated_at)));
                $diff = date_diff($dateActuel, $dateCommande);
                if ($diff->format('%a') > 14) {
                    $commande_suppr = Commandes::where('id', $commande_fini[$i]->id)->delete();

                    $commande_fini = Commandes::join('personnels', 'commandes.idPersonnel', 'personnels.id')->join('etats', 'commandes.idEtat', 'etats.id')->select('commandes.id', 'nomCommandes', 'quantiteDemande', 'commandes.updated_at', 'personnels.mail', 'etats.nomEtat')->where('personnels.mail', $Personnel[0]->mail)->where('etats.nomEtat', 'Livré')->orWhere('etats.nomEtat', 'Annulé')->orderby('commandes.id', 'asc')->get();
                }
            }

            $commande = Commandes::join('personnels', 'commandes.idPersonnel', 'personnels.id')->join('etats', 'commandes.idEtat', 'etats.id')->select('commandes.id', 'nomCommandes', 'quantiteDemande', 'commandes.updated_at', 'personnels.mail', 'etats.nomEtat')->where('personnels.mail', $Personnel[0]->mail)->where('etats.nomEtat', 'En cours')->orderby('commandes.id', 'asc')->get();

            $commande_liste = Commandes::join('personnels', 'commandes.idPersonnel', 'personnels.id')->join('etats', 'commandes.idEtat', 'etats.id')->select('commandes.id', 'nomCommandes', 'quantiteDemande', 'commandes.created_at', 'commandes.updated_at', 'personnels.nom', 'personnels.prenom', 'personnels.mail', 'etats.nomEtat')->where('etats.nomEtat', 'En cours')->orderby('commandes.updated_at', 'asc')->get();

            $Personnels = Personnel::join('services', 'personnels.idService', 'services.id')->join('categories', 'personnels.idCategorie', 'categories.id')->select('*')->orderby('personnels.id', 'asc')->get();

            $Fournitures = Fournitures::join('familles_fournitures', 'fournitures.idFamille', 'familles_fournitures.id')->select('fournitures.*', 'nomFamille')->orderby('fournitures.id', 'asc')->get();

            session_start();

            $_SESSION['nom'] = $Personnel[0]->nom;
            $_SESSION['prenom'] = $Personnel[0]->prenom;
            $_SESSION['mail'] = $Personnel[0]->mail;
            $_SESSION['pass'] = $Personnel[0]->pass;
            $_SESSION['categorie'] = $Personnel[0]->nomCategorie;
            $_SESSION['service'] = $Personnel[0]->nomService;
            $_SESSION['message'] = $Personnel[0]->message;
            $_SESSION['commandes'] = $commande;
            $_SESSION['commandes_fini'] = $commande_fini;
            $_SESSION['commandes_liste'] = $commande_liste;
            $_SESSION['personnels'] = $Personnels;
            $_SESSION['fournitures'] = $Fournitures;

            return redirect()->route($request->page);
        }
    }

    public function deconnexion()
    {
        session_start();

        $_SESSION = array();
        session_destroy();

        setcookie('login', '');
        setcookie('pass_hache', '');

        $deconnexion = true;

        return view('connexion', ['deconnexion'=>$deconnexion]);
    }

    public function afficher()
    {
        session_start();

        return view('accueil');
    }

    public function message(Request $request)
    {
        $validatedData = $request->validate([
            'message' => 'required|max:1500',
            'mail' => 'required',
        ]);

        if ($request->mail == 'tous') {
            $Personnel = Personnel::select('*')->update(['message' => $request->message]);
        } else {
            $Personnel = Personnel::where('mail', $request->mail)->update(['message' => $request->message]);
        }

        session_start();

        $Personnel = Personnel::where('mail', $_SESSION['mail'])->get();

        $Personnels = Personnel::join('services', 'personnels.idService', 'services.id')->join('categories', 'personnels.idCategorie', 'categories.id')->select('*')->orderby('personnels.id', 'asc')->get();

        $_SESSION['message'] = $Personnel[0]->message;
        $_SESSION['personnels'] = $Personnels;

        $vrai = true;

        return view('accueil', ['vrai'=>$vrai]);
    }

    public function supprimer(Request $request)
    {
        $validatedData = $request->validate([
            'mail' => 'required|email',
        ]);

        $Personnel = Personnel::where('mail', $request->mail)->update(['message' => '']);

        session_start();

        $Personnel = Personnel::where('mail', $_SESSION['mail'])->get();

        $Personnels = Personnel::join('services', 'personnels.idService', 'services.id')->join('categories', 'personnels.idCategorie', 'categories.id')->select('*')->orderby('personnels.id', 'asc')->get();

        $_SESSION['message'] = $Personnel[0]->message;
        $_SESSION['personnels'] = $Personnels;

        $suppr = true;

        return view('accueil', ['suppr'=>$suppr]);
    }

    public function suppressionmessages()
    {
        $Personnel = Personnel::select('*')->update(['message' => '']);

        session_start();

        $Personnel = Personnel::where('mail', $_SESSION['mail'])->get();
        //stocker dans la variable la requete selectionner la table personnel :: si bsn d'un jointure faire join
        $Personnels = Personnel::join('services', 'personnels.idService', 'services.id')->join('categories', 'personnels.idCategorie', 'categories.id')->select('*')->orderby('personnels.id', 'asc')->get();

        $_SESSION['message'] = $Personnel[0]->message;
        $_SESSION['personnels'] = $Personnels;

        $supprtous = true;

        return view('accueil', ['supprtous'=>$supprtous]);
    }

    public function modificationlogo(Request $request)
    {
        $validatedData = $request->validate([
            'photo_logo' => 'required',
        ]);

        session_start();

        if ($request->file('photo_logo')->getsize() > 500000) {

            $tropgros = true;

            return view('accueil', ['tropgros' => $tropgros]);
        }

        $fichierTelecharger = $request->file('photo_logo');
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
                $blanc = imagecolorallocate($photo, 255, 255, 255);
                imagecolortransparent($photo, $blanc);
                break;
            default:
                $invalide = true;
                return view('accueil', ['invalide' => $invalide]);
                break;
        }

        $nomChemin = '/var/www/html/PPE-3/Application/storage/app/public/logo-cci.png';

        imagepng($photo, $nomChemin);

        $modif = true;

        return view('accueil', ['modif' => $modif]);
    }

    public function suppressionlogo()
    {
        session_start();

        unlink('/var/www/html/PPE-3/Application/storage/app/public/logo-cci.png');

        $supprlogo = true;

        return view('accueil', ['supprlogo' => $supprlogo]);
    }

    public function messagerie()
    {
        session_start();

        if (!isset($_SESSION['mail'])) {
            header('Refresh: 0; url='.url('?page=messagerie'));
            exit;
        }
        if ($_SESSION['categorie'] != 'Administrateur') {
            $droitinsuf = true;
            return view('accueil', ['droitinsuf' => $droitinsuf]);
        } else {
            return view('messagerie');
        }
    }

    public function traitementmessagerie(Request $request)
    {
        session_start();

        $validatedData = $request->validate([
            'nom' => 'required',
            'email' => 'required',
            'objet' => 'required',
            'message' => 'required',
        ]);

        // traitement du formulaire
        $destinataire = 'sicmu608@gmail.com';
        $copie = 'oui';
        $form_action = '';
        $message_envoye = "Votre message a bien été envoyé";
        $message_non_envoye = "L'envoi du mail a échoué, veuillez réessayer SVP.";

        function Enregistrer($text)
        {
        	$text = htmlspecialchars(trim($text), ENT_QUOTES);

        	$text = stripslashes($text);

        	$text = nl2br($text);
        	return $text;
        };

        function IsEmail($email)
        {
        	$value = preg_match('/^(?:[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+\.)*[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+@(?:(?:(?:[a-zA-Z0-9_](?:[a-zA-Z0-9_\-](?!\.)){0,61}[a-zA-Z0-9_-]?\.)+[a-zA-Z0-9_](?:[a-zA-Z0-9_\-](?!$)){0,61}[a-zA-Z0-9_]?)|(?:\[(?:(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\.){3}(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\]))$/', $email);
        	return (($value === 0) || ($value === false)) ? false : true;
        }

        // recuperer les données du formulaire
        $nom     = Enregistrer($request->nom);
        $email   = Enregistrer($request->email);
        $objet   = Enregistrer($request->objet);
        $message = Enregistrer($request->message);

        // On va vérifier les variables et l'email ...
        $email = (IsEmail($email)) ? $email : '';
        $err_formulaire = false;

    	if (($nom != '') && ($email != '') && ($objet != '') && ($message != ''))
    	{
    		$headers  = 'MIME-Version: 1.0' . "\r\n";
    		$headers .= 'From:'.$nom.' <'.$email.'>' . "\r\n" .
    				'Reply-To:'.$email. "\r\n" .
    				'Content-Type: text/plain; charset="utf-8"; DelSp="Yes"; format=flowed '."\r\n" .
    				'Content-Disposition: inline'. "\r\n" .
    				'Content-Transfer-Encoding: 7bit'." \r\n" .
    				'X-Mailer:PHP/'.phpversion();
    				$EmailTo = "sicmu608@gmail.com";
    				$Subject = "Vous avez un nouveau message de " .$nom;

    		// envoyer une copie au visiteur
    		if ($copie == 'oui')
    		{
    			$cible = $destinataire.';'.$email;
    		}
    		else
    		{
    			$cible = $destinataire;
    		};

    		// Remplacement de certains caractères spéciaux
    		$message = str_replace("&#039;","'",$message);
    		$message = str_replace("&#8217;","'",$message);
    		$message = str_replace("&quot;",'"',$message);
    		$message = str_replace('<br>','',$message);
    		$message = str_replace('<br />','',$message);
    		$message = str_replace("&lt;","<",$message);
    		$message = str_replace("&gt;",">",$message);
    		$message = str_replace("&amp;","&",$message);

    		// Envoi du mail
    		$num_emails = 2;
    		$tmp = explode(';', $cible);
    		foreach($tmp as $email_destinataire)
    		{
    			if (mail($email_destinataire, $objet, $message, $headers))
    				$num_emails++;
    		}

            $envoi = true;

            return view('messagerie', ['envoi'=>$envoi, 'message_envoye'=>$message_envoye]);
    	}
    }

    public function recherchemail(Request $request)
    {
        session_start();

        $validatedData = $request->validate([
            'terme' => 'required',
        ]);

        $nb = 1;
        $aucun_result = false;
        if (isset($request->s) AND $request->s == "Rechercher")
        {
            $request->terme = htmlspecialchars($request->terme); //pour sécuriser le formulaire contre les failles html
            $terme = $request->terme;
            $terme = trim($terme); //supprimer des caractères au début et en fin d’une chaîne de caractère.
            $terme = strip_tags($terme);//Supprime les balises HTML et PHP d'une chaîne ...

        }

        if ($terme != "")
        {
            $rechercheExplode = explode(' ', $terme);
            $recherche = implode('%', $rechercheExplode);
            $select_terme = Personnel::where('nom', 'like', '%'.$recherche.'%')->orWhere('prenom', 'like', '%'.$recherche.'%')->orWhere('mail', 'like', '%'.$recherche.'%')->get();

            if (isset($select_terme[1]))
            {
                $nb = 2;
            }
        }
        if (!isset($select_terme[0])) {
            $aucun_result = true;
        }

        return view('messagerie', ['mail_result'=>$select_terme, 'nb'=>$nb, 'aucun_result'=>$aucun_result]);
    }


                /****************************************     Fonction Statistiques     ***************************************************/
        public function statistique()
        {
            session_start();

            if (!isset($_SESSION['mail'])) {
                header('Refresh: 0; url='.url('?page=statistique'));
                exit;
            }

            $Fournitures = Fournitures::select('*')->get();
            $Services = Service::select('*')->get();
            if ($_SESSION['categorie'] != 'Administrateur') {
                $droitinsuf = true;
                return view('accueil', ['droitinsuf' => $droitinsuf]);
              } else {
                  return view('statistique', ['Fournitures'=>$Fournitures, "Services"=>$Services]);
              }

        }

        public function stats_produit(Request $request)
        {
          session_start();
          $Services = Service::select('*')->get();
          $Fournitures = Fournitures::select('*')->get();
          if ($request->date1 > $request->date2) {
            $erreurdate='true';
            return view("statistique", ['erreurdate'=>$erreurdate, 'Fournitures'=>$Fournitures, "Services"=>$Services]);
          }

          $Statistiques_commande = Commandes::join('personnels','commandes.idPersonnel','personnels.id')->join('services', 'personnels.idService', 'services.id')->select('nomCommandes', 'nomService', 'quantiteDemande', 'commandes.created_at')->where('commandes.created_at','>=', $request->date1, 'AND','commandes.created_at','<=', $request->date2)->where('nomCommandes', $request->nom_produits)->orWhere('nomService', $request->nom_service)->get();
          $Statistiques_demande = DemandesSpecifiques::join('personnels','demandes_specifiques.idPersonnel','personnels.id')->join('services', 'personnels.idService', 'services.id')->select('nomDemande', 'nomService', 'quantiteDemande', 'demandes_specifiques.created_at')->where('demandes_specifiques.created_at','<=', $request->date1)->where('nomDemande', $request->nom_produits)->orWhere('nomService', $request->nom_service)->get();
          if (isset($Statistiques_commande[0]) OR isset($Statistiques_demande[0]) ) {
            $reponse = true;
          } else {
            $reponse = false;
          }
          return view("statistique", ['Statistiques_commande'=>$Statistiques_commande,'Statistiques_demande'=>$Statistiques_demande , 'Fournitures'=>$Fournitures, "Services"=>$Services, "reponse"=>$reponse]);
        }

    public function personnalisationducompte()
    {
        session_start();

        if (!isset($_SESSION['mail'])) {
            header('Refresh: 0; url='.url('?page=personnalisationducompte'));
            exit;
        }

        return view('personnalisationducompte');
    }
}
